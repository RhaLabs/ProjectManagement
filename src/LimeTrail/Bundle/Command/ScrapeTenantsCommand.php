<?php
namespace LimeTrail\Bundle\Command;

use ReflectionClass;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use LimeTrail\Bundle\Command\QuickBase\QuickBaseWeb;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Entity\ChangeInitiation;
use LimeTrail\Bundle\Entity\ProjectChangeInitiation;
use LimeTrail\Bundle\Entity\ChangeScope;

class ScrapeTenantsCommand extends ContainerAwareCommand
{
    protected $em;
    
    protected $logger;

    protected function configure()
    {
        $this->setName('limetrail:scrapetenants')
         ->setDescription('QuickBase tenant web scraper')
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
        
        foreach($storeList AS $store) {
          $storeNumber = $store->getStoreNumber();
          $storeProjects = $store->getProjects();
          
          foreach($storeProjects AS $project) {
            /*
             * Inorder to get tenants for a particular project we need to do a GET request to
             * curl https://wmt.quickbase.com/db/bgh5rjx8u
             * where the query string should look like this:
             *  a:q
             *  qid:1
             *  query:{'56'.EX.'6209.001'}
             *                    ^store number and sequence
             */
            $format = "{'56'.EX.'%d.%03d'}";
            
            $sequence = $project->getSequence();
            
            $query = sprintf($format, $storeNumber, $sequence);
            
            $queryString = array(
              'a' => 'q',
              'qid' => '1',
              'query' => $query
            );
            
            $escapedQuery = http_build_query($queryString);
            
            $url = "https://wmt.quickbase.com/db/bgh5rjx8u?".$escapedQuery;
            
            $tableHTML = $quickbase->GetTable($url);
            // table to get as CSV link https://wmt.quickbase.com/db/bfngn7tvg?a=q&qid=1002789&dlta=xs~
            $result = $quickbase->ParseHTML($tableHTML);
            
            //$this->getContainer()->get('doctrine')->resetManager();
            $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
            
            echo "Processing tenants for: ".$storeNumber.".".$project->getSequence()."\n";
            $this->ProcessStoreTenants($result, $quickbase, $project);

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
        
        $this->logger->warning(sprintf("Checked %d stores for tenants\n", $storeCount)); 
    }
    
    private function ProcessStoreTenants($result, $quickbase, $project)
    {
       //now to check to see if this project already has the tenant
       // we also need to find out if we need to delete a tenant
       $provider = $this->getContainer()->get('lime_trail_store.provider');
  
       foreach ($result as $entry) {
          $change = $this->GetTenants($entry['CI #'], $quickbase);

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
            foreach( $projectChange AS $theChange) {
              $this->UpdateAndPersistProjectChange($entry, $theChange);
            }
          }
       }
    }
    
    private function UpdateAndPersistProjectChange($data, $projectChange)
    {
            $tenant = $data['Tenant or Concept'];
            $tenantType = $data['Tenant Type'];
            
            if (stripos($decline, 'accept') !== false ) {
              $projectChange->setAccepted(true)
                            ->setDrawingChangeNumber($drawingChangeNumber)
                            ->setDrawingChange($drawingChange);

              $date = $this->TryConvertDate($implementDate);
              
              if($date) {
                $projectChange->setDateImplemented($date);
              }
                            
            } elseif (stripos($decline, 'decline') !== false) {
              $projectChange->setDeclined(true);
            }

            $this->em->persist($projectChange);
    }

}
