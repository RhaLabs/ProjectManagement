<?php
namespace LimeTrail\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SqlMaintenceCommand extends ContainerAwareCommand
{
    protected $em;
    protected $dbpass;

    protected function configure()
    {
        $this->setName('limetrail:sqlmaintence')
         ->setDescription('analyzes sql tables')
         ->addOption('dbpass', null, InputOption::VALUE_REQUIRED, 'Sets database password to use', '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dbpass = $input->getOption('dbpass');

        $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');

        $dbhost = 'localhost';

        $dbuser = 'root';

        $dbpassword = $this->dbpass;

        $database = 'limetrail';

        $mysql = new \mysqli($dbhost, $dbuser, $dbpassword, $database);

    /* check connection */
    if ($mysql->connect_errno) {
        printf("Connect failed: %s\n", $mysql->connect_error);
        exit();
    }

        $SQL = "UPDATE `symfony`.`fos_user_user` SET `symfony`.`fos_user_user`.`locked` = 1 WHERE `symfony`.`fos_user_user`.`updated_at` < DATE_SUB(CURDATE(), INTERVAL 2 MONTH)";
        $result = $mysql->query($SQL) or die("Couldn't execute query.".mysql_error());

        $result->free();

        $SQL = "FLUSH QUERY CACHE";
        $result = $mysql->query($SQL) or die("Couldn't execute query.".mysql_error());

        $SQL = "FLUSH LOGS";

        $result = $mysql->query($SQL) or die("Failed flushing logs.".mysql_error());

        $SQL = "PURGE BINARY LOGS BEFORE DATE(NOW() - INTERVAL 3 DAY) + INTERVAL 0 SECOND";

        $mysql->close();

        echo "End of SQL Maintenence";
    }
}
