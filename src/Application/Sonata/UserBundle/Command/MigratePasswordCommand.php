<?php
namespace Application\Sonata\UserBundle\Command;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class MigratePasswordCommand extends ContainerAwareCommand
{
    protected $em;

    protected static $role = 'ROLE_FORCEPASSWORDCHANGE';

    protected $isDebugMode = false;

    protected function configure()
    {
        $this->setName('application:sonatauser:migratepassword')
         ->setDescription('migrates passwords in the database from one encoder to another')
         ->addOption('dbpass', null, InputOption::VALUE_REQUIRED, 'Sets database password to use', '')
         ->addOption('debug', null, InputOption::VALUE_NONE, 'if set will skip the emailer and output to file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbpass = $input->getOption('dbpass');

        if ($input->getOption('debug')) {
            $this->isDebugMode = true;
        }

        $this->em = $this->getContainer()->get('doctrine')->getManager();

        $repo = $this->em->getRepository('ApplicationSonataUserBundle:User');

        $users = $repo->findAll();

        foreach ($users as $user) {
            $this->changePasswordAndSendEmail($user);

            $this->em->persist($user);
            $this->em->flush();
        }
    }

    protected function changePasswordAndSendEmail(User $user)
    {
        $password = $this->generatePassword();

        $user->setPassword($this->migrateBcryptPassword($password, $user->getSalt()));

        $user->setEncoderName('default');

        $this->emailUser($user, $password);
    }

    protected function emailUser(User $user, $password)
    {
        $email = $user->getEmail();

        if ($this->isDebugMode) {
            $resource = fopen("password-$email.txt", 'w');

            fwrite($resource, $password);
            fclose($resource);
        } else {
            $route = $this->getContainer()->get('router')->generate('fos_user_change_password');

            $body = "We upgraded our web server's security mechanisms which caused all passwords to be reset.<br/>  Your temporary password is $password<br/>  You can reset your password at this link:<a href='$route'>$route</a>";

            $message = \Swift_Message::newInstance()
              ->setSubject('Your password has been automatically reset')
              ->setFrom(array('noreply@rhaaia.com' => 'RHA Web Robot'))
              ->setTo($email['email'])
              ->setBody(
                $this->getContainer()->get('templating')->render(
                  'ApplicationSonataUserBundle:Email:default.email.html.twig',
                  array(
                    'result' => $result,
                    'body_message' => $body,
                    'user' => $user,
                  )
                ), 'text/html'
              );

            $body = "We upgraded our web server's security mechanisms which caused all passwords to be reset.  Your temporary password is $password  You can reset your password at this link: $route";

            $message->addPart($this->getContainer()->get('templating')->render(
                  'ApplicationSonataUserBundle:Email:default.email.txt.twig',
                  array(
                    'result' => $result,
                    'body_message' => $body,
                    'user' => $user,
                  )
                ), 'text/plain'
              );

            $this->getContainer()->get('mailer')->send($message);
        }
    }

    protected function migrateBcryptPassword($raw, $salt)
    {
        $crypter = new BCryptPasswordEncoder(13);

        return $crypter->encodePassword($raw, $salt);
    }

    protected function generatePassword()
    {
        return substr(md5(uniqid(rand(), true)), 0, 8);
    }
}
