<?php
namespace LimeTrail\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use LimeTrail\Bundle\Command\QuickBase\QuickBaseWeb;
use LimeTrail\Bundle\Entity\ChangeInitiation;
use LimeTrail\Bundle\Entity\ProjectChangeInitiation;
use LimeTrail\Bundle\Entity\ChangeScope;

class ScrapeChangesCommand extends ContainerAwareCommand
{
    protected $em;

    protected $logger;

    protected function configure()
    {
        $this->setName('limetrail:scrapechanges')
         ->setDescription('QuickBase CI web scraper')
         ->addOption('user', null, InputOption::VALUE_REQUIRED, 'Sets username for web login', '')
         ->addOption('login-pass', null, InputOption::VALUE_REQUIRED, 'Sets login password for web login', '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger = $this->getContainer()->get('logger');

        $username = $input->getOption('user');

        $dbhost = $this->getContainer()->getParameter('database_host');

        $dbuser = $this->getContainer()->getParameter('database_user');

        $webPass = $input->getOption('login-pass');

        //quickbase web
        $quickbase = new QuickBaseWeb($username, $webPass, 'wmt', $this->getContainer()->getParameter('database_password'), $dbhost, $dbuser);

        // first pass - get cookies
        $result = $quickbase->Login();

        while (!false === stripos($result, 'Operation timed out')) {
            $quickbase->Login();
        }
        //second pass - log in
        $quickbase->Login();//'qb-'.urlencode($url).'.html'

        $storeList = $this->getContainer()->get('lime_trail_store.provider')->findCurrentProjects(new \DateTime(date('Y-m-d')));

        $storeCount = 0;

        foreach ($storeList as $store) {
            $storeNumber = $store->getStoreNumber();
            $storeProjects = $store->getProjects();

            foreach ($storeProjects as $project) {
                /*
             * Inorder to get CI's for a particular project we need to do a GET request to
             * curl "https://wmt.quickbase.com/db/bcqqdvttp
             * where the query string should look like this:
             *  a:q
             *  qt:tab
             *  opts:nos
             *  query:{'252'.EX.'4204.000'}
             *                    ^store number and sequence
             */
            $format = "{'252'.EX.'%d.%03d'}";

                $sequence = $project->getSequence();

                $query = sprintf($format, $storeNumber, $sequence);

                $queryString = array(
              'a' => 'q',
              'qt' => 'tab',
              'opts' => 'nos',
              'query' => $query,
            );

                $escapedQuery = http_build_query($queryString);

                $url = "https://wmt.quickbase.com/db/bcqqdvttp?".$escapedQuery;

                $tableHTML = $quickbase->GetTable($url);
            // table to get as CSV link https://wmt.quickbase.com/db/bfngn7tvg?a=q&qid=1002789&dlta=xs~
            $result = $quickbase->ParseHTML($tableHTML);

            //$this->getContainer()->get('doctrine')->resetManager();
            $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');

                echo "Processing changes for: ".$storeNumber.".".$project->getSequence()."\n";
                $this->ProcessStoreChanges($result, $quickbase, $project);

                try {
                    $this->em->flush();
                } catch (\Symfony\Component\Debug\Exception\ContextErrorException $e) {
                    $this->logger->error("failed to synchronize ".$storeNumber.".".$project->getSequence());

                    $this->logger->debug(\Doctrine\Common\Util\Debug::dump($e->getContext()));

                    throw $e;
                }
            //$this->em->clear();
            gc_collect_cycles();

                ++$storeCount;
            }
        }

        $this->logger->warning(sprintf("Checked %d stores for Change Initiations\n", $storeCount));
    }

    private function ProcessStoreChanges($result, $quickbase, $project)
    {
        //now to check to see if this project already has the CI and add it if not
       $provider = $this->getContainer()->get('lime_trail_store.provider');

        foreach ($result as $entry) {
            $this->logger->notice(sprintf("looking up change %s\n", $entry['ci #']));
            $this->logger->debug(print_r($entry, true));
            if (empty($entry['ci #']) OR strlen(trim($entry['ci #'])) === 0) {
                continue;
            }
            
            $change = $this->GetChangeInitiation($entry['ci #'], $quickbase);
            $this->logger->info(sprintf("finding change with number %s\n", $change->getNumber()));

            $projectChange = $provider->findProjectChangesByProjectAndChange($project, $change);

            if (empty($projectChange)) {
                //create a new project change
            //echo "creating a new ProjectChangeInitiation\n";
            $projectChange = new ProjectChangeInitiation();

                $projectChange->addProject($project)
                          ->addChange($change)
                          ->setDateAssigned(new \DateTime(date('Y-m-d')));

                $this->em->persist($project);
                $this->em->persist($change);

                $this->UpdateAndPersistProjectChange($entry, $projectChange);
            } else {
                //update existing project change
            foreach ($projectChange as $theChange) {
                $this->UpdateAndPersistProjectChange($entry, $theChange);
            }
            }
        }
    }

    private function UpdateAndPersistProjectChange($data, $projectChange)
    {
        $decline = $data['accept_decline'];
        $implementDate = $data['implementation_act'];
        $drawingChange = $data['change_type'];
        $drawingChangeNumber = $data['revision_addendum_ccd#'];

        if (stripos($decline, 'accept') !== false) {
            $projectChange->setAccepted(true)
                            ->setDrawingChangeNumber($drawingChangeNumber)
                            ->setDrawingChange($drawingChange);

            $date = $this->TryConvertDate($implementDate);

            if ($date) {
                $projectChange->setDateImplemented($date);
            }
        } elseif (stripos($decline, 'decline') !== false) {
            $projectChange->setDeclined(true);
        }

        $this->em->persist($projectChange);
    }

    private function GetChangeInitiation($ciNumber, $quickbase)
    {
        $ci = $this->em->getRepository('LimeTrailBundle:ChangeInitiation')->findOneByNumber($ciNumber);

        if (!$ci or $ci === null) {
            //make new CI
              $ci = new ChangeInitiation();

            $ci->setNumber($ciNumber);

            $query = "{'288'.EX.'".$ciNumber."'}";

            $queryString = array(
                'a' => 'q',
                'qt' => 'tab',
                'opts' => 'nos',
                'query' => $query,
              );

            $escapedQuery = http_build_query($queryString);

            $url = "https://wmt.quickbase.com/db/bcqqdvttv?".$escapedQuery;

            $ciTablePage = $quickbase->GetTable($url);
            $ciInfo = $quickbase->parseCiTable($ciTablePage);

              /*$resource = fopen("ci-$ciNumber.txt", 'w');
              fwrite($resource, print_r($ciInfo, true));
              fclose($resource);*/

              $ci->setReleaseDate($this->TryConvertDate($ciInfo['release_date']))
                 ->setComment($ciInfo['comments'])
                 ->setTitle($ciInfo['ci_title']);

            $scope = $this->GetScopes($ciInfo['scope_of_implementation']);

            $ci->setScopes($scope);

              //echo "Persisting CI $ciNumber\n";
              $this->em->persist($ci);
            $this->em->flush();
        }

        return $ci;
    }

    private function GetScopes($list)
    {
        if (!is_string($list)) {
            throw new UnexpectedTypeException();
        }

      //replace places where they use ' - ' as a separator
      $list = preg_replace('~\s-\s~', ', ', $list);

      //explode list by separator
      $parts = explode(', ', $list);

        $assoc = array();

      //iterate parts, scope names will be keys and values will be DateTimes or empty strings
      foreach ($parts as $part) {
          $new = explode(': ', $part);

          if (count($new) > 1) {
              $assoc[$new[0]] = $this->TryConvertDate($new[1]);
          } else {
              $assoc[$new[0]] = "";
          }
      }

      //create an array of scope objects
      $scopes = array();

        foreach ($assoc as $key => $value) {
            $scope = new ChangeScope();

            $scope->setName($key);

            if ($value instanceof \DateTime) {
                $scope->setDate($value);
            }

            $this->em->persist($scope);
            $scopes[] = $scope;
        }

        return $scopes;
    }

    protected function TryConvertDate($dateString)
    {
        if (preg_match('/(?:(?P<month>\d{1,2})-(?P<day>\d{1,2})-(?P<year>\d{4}))/', $dateString, $matches) === 1) {
            if (checkdate($matches["month"], $matches["day"], $matches["year"])) {
                return new \DateTime($matches["month"]."/".$matches["day"]."/".$matches["year"]);
            }
        }

        return;
    }
}
