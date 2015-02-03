<?php
namespace LimeTrail\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Entity\Dates;

class EraseDatesCommand extends ContainerAwareCommand
{
    private $dbpass = null;
    private $dbhost = '';
    private $dbuser = '';
    private $when = null;

    public function configure()
    {
        $this->setName('limetrail:erasedates')
         ->setDescription('data eraser')
         ->addOption('dbpass', null, InputOption::VALUE_REQUIRED, 'Sets database password to use', '')
         ->addOption('when', null, InputOption::VALUE_REQUIRED, 'Erases data from the dates table and fixes foreign keys', '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbpass = $input->getOption('dbpass');

        $when = $input->getOption('when');

        if ($dbpass) {
            $this->dbpass = $dbpass;
        }

        if (!$when) {
            $this->when =  new \DateTime(date('Y-m-d'));
        }

        $this->dbhost = $this->getContainer()->getParameter('database_host');

        $this->dbuser = $this->getContainer()->getParameter('database_user');

        $this->Retrievedata();
    }

    public function Retrievedata()
    {
        $database = 'limetrail';

        $dsn = 'mysql:host='.$this->dbhost.';dbname='.$database;
        $options = array( \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        $dbcon = new \PDO($dsn, $this->dbuser, $this->dbpass, $options);

        $date = $this->when->format('Y-m-d');

        print $date."\n";

        $SQL = "SELECT * FROM `projects_trident_dates` join trident on projects_trident_dates.Trident_id = trident.id WHERE trident.runDate = \"$date\"";

        $sth = $dbcon->prepare($SQL);
        $sth->execute();

        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $this->deleteFromLinkingTable($row['dates'], $row['Trident_id'], $dbcon);

            $this->deleteFromTridentTable($row['Trident_id'], $dbcon);
        }
    }

    public function deleteFromLinkingTable($dates, $trident_id, $connection)
    {
        $SQL = "DELETE FROM `projects_trident_dates` WHERE `dates` = $dates AND `Trident_id` = $trident_id";

        $sth = $connection->prepare($SQL);

        $sth->execute();

        print "DELETED FROM `projects_trident_dates` : ".$sth->rowCount()."\n";
    }

    public function deleteFromTridentTable($id, $connection)
    {
        $SQL = "DELETE FROM `trident` WHERE `id` = $id";

        $sth = $connection->prepare($SQL);

        $sth->execute();

        print "DELETED FROM `trident` : ".$sth->rowCount()."\n";
    }
}
