<?php
namespace LimeTrail\Bundle\Command;

use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\JobRole;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Entity\Zip;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\ProjectContacts;

class ContactCommand extends ContainerAwareCommand
{
    protected $em;
    protected $contactprovider;
    protected $companyprovider;

    protected function configure()
    {
        $this->setName('limetrail:contact')
         ->setDescription('loads contacts from a csv file')
         ->addArgument('path', InputArgument::REQUIRED, 'provide the path the to file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        $data = $this->ParseCSV($path);

        $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');

        $this->contactprovider = $this->getContainer()->get('lime_trail_contact.provider');

        $this->companyprovider = $this->getContainer()->get('lime_trail_company.provider');

        foreach ($data as $row) {
            $office = $this->ProcessCompany($row);

            $this->ProcessContact($office, $row);
            $this->em->flush();
            print "flushed contact\n";
            $this->em->clear();
            gc_collect_cycles();
        }
    }

    private function ProcessCompany($row)
    {
        try {
            $company = $this->companyprovider->getCompany($row['company_name']);
        } catch (\Doctrine\ORM\NoResultException $e) {
            $company = $this->companyprovider->createCompany($row['company_name']);
            echo "create new company\n";

            return $this->createOffice($company, $row);
        }

        if (!$company) {
            $company = $this->companyprovider->createCompany($row['company_name']);
            echo "create new company\n";

            return $this->createOffice($company, $row);
        } else {
            //$office = $this->companyprovider->getOfficeByAddress($company, $row["street"].', '.$row['suite']);
      try {
          $office = $this->companyprovider->getOfficeByPhone($company, $row["main_phone"]);

          if (!$office) {
              $office = $this->createOffice($company, $row);
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          $office = $this->createOffice($company, $row);
      }

            return $office;
        }
    }

    private function createOffice($company, $row)
    {
        $office = $this->companyprovider->createOffice($company);
        echo "Create new Office\n";

        $office->setAddress($this->contactprovider->getProvider()->getAddress($row["street"].', '.$row['suite'], 0, 0))
              ->setMainPhone($row["main_phone"])
              ->setFax($row["fax"])
              ->setState($this->getContainer()->get('lime_trail_state.provider')->getState($row["state"]))
              ->setCity($this->getContainer()->get('lime_trail_city.provider')->getCityFromState($row["city"], $office->getState()))
              ->setZip($this->getContainer()->get('lime_trail_state.provider')->getZipcode((int) $row["zip"]))
      ;
        echo "Set Office info\n";

        $this->em->persist($office);

        return $office;
    }

    private function ProcessContact($office, $row)
    {
        try {
            $contact = $this->contactprovider->getContact($row['first_name'], $row['middle_name'], $row['last_name']);

            if (!$contact) {
                $contact = $this->CreateContact($row);
            } else {
                $contact = $this->contactprovider->updateContact($contact, array(
            'FirstName' => $row['first_name'],
            'MiddleName' => $row['middle_name'],
            'LastName' => $row['last_name'],
            'JobTitle' => $row['job_title'],
            'DirectPhone' => $row['direct_phone'],
            'MobilePhone' => $row['mobile_phone'],
            'Email' => $row['email'],
            'Website' => '',
            )
          );
            }
        } catch (\Doctrine\ORM\NoResultException $e) {
            $contact = $this->CreateContact($row);
        }

        $this->relateProjectAndJobrole($contact, $row);

        $contact->addOffice($office);
        $this->em->persist($contact);
        $this->em->persist($office);
    }

    private function relateProjectAndJobrole($contact, $row)
    {
        if (!isset($row["str_num"])) {
            return;
        }

        try {
            $jobrole = $this->contactprovider->findJobRole($row['job_role']);

            if (!$jobrole) {
                $jobrole = new JobRole();
                $jobrole->setJobRole($row['job_role']);
                $this->em->persist($jobrole);
            }
        } catch (\Doctrine\ORM\NoResultException $e) {
            $jobrole = new JobRole();
            $jobrole->setJobRole($row['job_role']);
            $this->em->persist($jobrole);
        }

        $store = $this->em->getRepository('LimeTrailBundle:StoreInformation')
                      ->findByNumberAndSequence($row["str_num"], $row["str_seq"]);

        if (isset($store)) {
            $projects = $store->getProjects();

            $project = $projects[0];

            $projectcontact = new ProjectContacts();

            $projectcontact->addProject($project)
                   ->addJobRole($jobrole)
                   ->addContact($contact);

            $this->em->persist($projectcontact);
        }
    }

    private function CreateContact($row)
    {
        return $this->contactprovider->createContact(array(
            'FirstName' => $row['first_name'],
            'MiddleName' => $row['middle_name'],
            'LastName' => $row['last_name'],
            'JobTitle' => $row['job_title'],
            'DirectPhone' => $row['direct_phone'],
            'MobilePhone' => $row['mobile_phone'],
            'Email' => $row['email'],
            'Website' => '',
            )
        );
    }

    public function ParseCSV($file)
    {
        $data = array();

        $rowcount = 0;

        if (($handle = fopen($file, "r")) !== false) {
            $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 0;
            $header = fgetcsv($handle, $max_line_length);
            $header_colcount = count($header);
            while (($row = fgetcsv($handle, $max_line_length)) !== false) {
                $row_colcount = count($row);
                if ($row_colcount == $header_colcount) {
                    $entry = array_combine($header, $row);
                    $data[] = $entry;
                } else {
                    error_log("csvreader: Invalid number of columns at line ".($rowcount + 2)." (row ".($rowcount + 1)."). Expected=$header_colcount Got=$row_colcount");

                    return;
                }
                $rowcount++;
            }
        //echo "Totally $rowcount rows found\n";
        fclose($handle);
        } else {
            error_log("csvreader: Could not read CSV \"$csvfile\"");

            return;
        }

        return $data;
    }
}
