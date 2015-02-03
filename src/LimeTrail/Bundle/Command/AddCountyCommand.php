<?php

namespace LimeTrail\Bundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\County;
use LimeTrail\Bundle\Entity\State;

class AddCountyCommand extends PopulateGeoCommand
{
    protected $em;
    protected function configure()
    {
        $this->setName('limetrail:addcounty')
         ->setDescription('add county')
         ->addArgument('state', InputArgument::REQUIRED, 'Provide the 2 letter state abbreviation')
         ->addArgument('city', InputArgument::REQUIRED, 'Provide the city name. You must quote " if the name contains spaces')
         ->addArgument('county', InputArgument::REQUIRED, 'Provide the county name. You must quote " if the name contains spaces')
         ->addOption('countyurl', null, InputOption::VALUE_REQUIRED, 'Sets the URL to the county website, if provided', 'todo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $county = $input->getArgument('county');
        if (false === preg_match('/\b(County)/', $county)) {
            $county .= " County";
        }
        print $county;
        $json = '[{"name":"'.$county.
        '","url":"'.$input->getOption('countyurl').'"},'.
        '{"name":"'.$input->getArgument('city').'"},'.
        '{"state_abbreviation":"'.$input->getArgument('state').'"}]';
        $this->addCounty($json);
    }

    public function addCounty($json)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
        $qb = $this->em->getRepository('LimeTrailBundle:State');
        $obj = $this->mjson_decode($json);
        $state = $obj[2];
        $city = $obj[1];
        $county = $obj[0];

        $s = $this->getState($state->state_abbreviation, $qb);
      //check for existence otherwise make a state
      if (!$s) {
          exit();
      }

        $cities = $s->getCities();
        $counties = $s->getCounties();
        $test = $this->findInResult($counties, $county->name);
        if (!$test || $test->isEmpty()) {
            $t = $this->createOrUpdate("County", $s, $county);
            $citytest = $this->findInResult($cities, $city->name);
            if (!$citytest || $citytest->isEmpty()) {
                $c = $this->createfeature("City", $s, $city);
                $c->addCounty($t);
            } else {
                $c = $citytest->first();
                $c->addCounty($t);
            }
        } else {
            //output duplicate found
        }
        $this->em->persist($s);
        $this->em->flush();
    }
}
