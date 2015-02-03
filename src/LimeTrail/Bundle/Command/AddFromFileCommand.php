<?php

namespace LimeTrail\Bundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\County;
use LimeTrail\Bundle\Entity\State;

class AddFromFileCommand extends PopulateGeoCommand
{
    protected $em;
    protected function configure()
    {
        $this->setName('limetrail:addfromfile')
         ->setDescription('create city')
         ->addArgument('path', InputArgument::REQUIRED, 'path to USGS state data files from http://geonames.usgs.gov/domestic/download_data.htm');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $paths = $this->directoryToArray($input->getArgument('path'), false);
        $features = array();
        foreach ($paths as $path) {
            array_push($features, $this->getFeatureArray($path));
        }
//print_r($features);

    foreach ($features as $feature) {
        $this->addCity($feature);
    }
    }

    private function getFeatureArray($path)
    {
        $features = array();
        $importer = new CsvImporter($path, true, '|');
        $data = $importer->get();
        foreach ($data as $d) {
            if ($d["FEATURE_CLASS"] === "Populated Place" and array_key_exists('STATE_ALPHA', $d) and isset($d["STATE_ALPHA"])) {
                array_push($features, $d);
            }
        }
        gc_collect_cycles();

        return $features;
    }

    public function addCity($features)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
        $qb = $this->em->getRepository('LimeTrailBundle:State');

        foreach ($features as $feature) {
            /*$obj = $this->mjson_decode($json);
    $state = $obj[2];
    $city = $obj[1];
    $county = $obj[0];*/

      $s = $this->getState($feature["STATE_ALPHA"], $qb);
      //check for existence otherwise make a state
      if (!$s) {
          $s = new State();
          $s->setName($feature["STATE_ALPHA"]);
          $s->setAbbreviation($feature["STATE_ALPHA"]);
          $s->setUrl("todo");
          $this->em->persist($s);
      }
    //print "state ".$s->getAbbreviation()."\n";
    $cities = $s->getCities(); //echo count($cities)."\n";
    $test = $this->findInResult($cities, $feature["FEATURE_NAME"]);
            if (!$test || $test->isEmpty()) {
                $c = $this->createfeature("City", $s, $feature);
                $t = $this->createOrUpdate("County", $s, $feature);
                $c->addCounty($t);//print "  city ".$c->getName()."\n";print "  county ".$t->getName()."\n";
            } else {
                //output duplicate found
            }
        }
        $this->em->persist($s);
        $this->em->flush();
        print "flushed state".$s->getName()."\n";
        $this->em->clear();
        gc_collect_cycles();
    }

    private function directoryToArray($directory, $recursive = true, $listDirs = false, $listFiles = true, $exclude = '')
    {
        $arrayItems = array();
        $skipByExclude = false;
        $handle = opendir($directory);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip);
                if ($exclude) {
                    preg_match($exclude, $file, $skipByExclude);
                }
                if (!$skip && !$skipByExclude) {
                    if (is_dir($directory.DIRECTORY_SEPARATOR.$file)) {
                        if ($recursive) {
                            $arrayItems = array_merge($arrayItems, directoryToArray($directory.DIRECTORY_SEPARATOR.$file, $recursive, $listDirs, $listFiles, $exclude));
                        }
                        if ($listDirs) {
                            $file = $directory.DIRECTORY_SEPARATOR.$file;
                            $arrayItems[] = $file;
                        }
                    } else {
                        if ($listFiles) {
                            $file = $directory.DIRECTORY_SEPARATOR.$file;
                            $arrayItems[] = $file;
                        }
                    }
                }
            }
            closedir($handle);
        }

        return $arrayItems;
    }
}
class CsvImporter
{
    private $fp;
    private $parse_header;
    private $header;
    private $delimiter;
    private $length;
    //--------------------------------------------------------------------
    public function __construct($file_name, $parse_header = false, $delimiter = "\t", $length = 8000)
    {
        $this->fp = fopen($file_name, "r");
        $this->parse_header = $parse_header;
        $this->delimiter = $delimiter;
        $this->length = $length;
        //$this->lines = $lines;

        if ($this->parse_header) {
            $this->header = fgetcsv($this->fp, $this->length, $this->delimiter);
        }
    }
    //--------------------------------------------------------------------
    public function __destruct()
    {
        if ($this->fp) {
            fclose($this->fp);
        }
    }
    //--------------------------------------------------------------------
    public function get($max_lines = 0)
    {
        //if $max_lines is set to 0, then get all the data

        $data = array();

        if ($max_lines > 0) {
            $line_count = 0;
        } else {
            $line_count = -1;
        } // so loop limit is ignored

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) {
            if ($this->parse_header) {
                foreach ($this->header as $i => $heading_i) {
                    $row_new[$heading_i] = $row[$i];
                }
                $data[] = $row_new;
            } else {
                $data[] = $row;
            }

            if ($max_lines > 0) {
                $line_count++;
            }
        }

        return $data;
    }
    //--------------------------------------------------------------------
}
