<?php

namespace LimeTrail\Bundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\County;
use LimeTrail\Bundle\Entity\State;

class AddCityCommand extends PopulateGeoCommand
{
    protected $em;
    protected function configure()
    {
        $this->setName('limetrail:addcity')
         ->setDescription('create city')
         ->addArgument('state', InputArgument::REQUIRED, 'Provide the 2 letter state abbreviation')
         ->addArgument('city', InputArgument::REQUIRED, 'Provide the city name. You must quote " if the name contains spaces')
         ->addOption('cityurl', null, InputOption::VALUE_REQUIRED, 'Sets the URL to the city website, if provided', 'todo')
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
        '{"url":"'.$input->getOption('cityurl').
        '","name":"'.$input->getArgument('city').'"},'.
        '{"state_abbreviation":"'.$input->getArgument('state').'"}]';
        $this->addCity($json);
    }

    public function addCity($json)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
        $qb = $this->em->getRepository('LimeTrailBundle:State');
        $obj = $this->mjson_decode($json);
        $state = $obj[2];
        $city = $obj[1];
        $county = $obj[0];

        $s = $this->getState($state->state_abbreviation);
      //check for existence otherwise make a state
      if (!$s) {
          exit();
      }

        $cities = $s->getCities(); //echo count($cities)."\n";
    $test = $this->findInResult($cities, $city->name);
        if (!$test || $test->isEmpty()) {
            $c = $this->createfeature("City", $s, $city);
            $t = $this->createOrUpdate("County", $s, $county);
            $c->addCounty($t);
        } else {
            //output duplicate found
        }
        $this->em->persist($s);
        $this->em->flush();
    }
}
