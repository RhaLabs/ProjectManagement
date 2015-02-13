<?php
namespace LimeTrail\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DateEmailerCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('limetrail:emailer')
         ->setDescription('emails entitlements about upcoming dates');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->emailEntitlementShells();

        $this->emailFinalShells();
    }

    private function emailEntitlementShells()
    {
        $em = $this->getContainer()->get('doctrine')->getManager('limetrail');

        $today = new \DateTime(date('Y-m-d'));

        $theFuture = clone $today;
        $theFuture->add(new \DateInterval('P70D'));

        $days = clone $today;
        $days->add(new \DateInterval('P60D'));

        $query = $em->createQuery(
        'SELECT CONCAT(CONCAT(si.storeNumber, \'-\'), pi.Sequence) AS number,
            pi.id,
            pi.canonicalName,
            d.pwoPrj,
            st.name AS type
          FROM LimeTrail\Bundle\Entity\StoreInformation si
          LEFT JOIN si.projects pi
          LEFT JOIN pi.ProjectStatus ps
          INNER JOIN pi.dates d
          LEFT JOIN si.storeType st
          WHERE
            ps.name = :status
            AND d.runDate = :today
            AND d.pwoPrj <= :thefuture
            AND d.pwoPrj >= :days
          ORDER BY d.pwoPrj DESC'
        )
        ->setParameter(':status', 'Active')
        ->setParameter(':today', $today, \Doctrine\DBAL\Types\Type::DATETIME)
        ->setParameter(':thefuture', $theFuture, \Doctrine\DBAL\Types\Type::DATETIME)
        ->setParameter(':days', $days, \Doctrine\DBAL\Types\Type::DATETIME)
        ;

        $result = $query->getArrayResult();

        if (!empty($result)) {
            $em = $this->getContainer()->get('doctrine')->getManager();

            $query = $em->createQuery(
            'SELECT u.email
             FROM Application\Sonata\UserBundle\Entity\User u
             JOIN u.groups g
             WHERE
              g.name = :group'
          )
          ->setParameter(':group', 'Entitlement');

            $emails = $query->getArrayResult();

            $body = 'I found some stores which should have PWO shells completed for them.  You might want to double check.';

            $message = \Swift_Message::newInstance()
            ->setSubject('Stores with approaching PWO shells due')
            ->setFrom(array('noreply@rhaaia.com' => 'RHA Web Robot'))
            ->setTo($this->array_flatten($emails))
            ->setBody(
              $this->getContainer()->get('templating')->render(
                'LimeTrailBundle:Email:shelldue.email.html.twig',
                array(
                  'result' => $result,
                  'body_message' => $body,
                )
              ), 'text/html'
            );
            $message->addPart($this->getContainer()->get('templating')->render(
                'LimeTrailBundle:Email:shelldue.email.txt.twig',
                array(
                  'result' => $result,
                  'body_message' => $body,
                )
              ), 'text/plain'
            );

            $this->getContainer()->get('mailer')->send($message);
        }
    }

    private function emailFinalShells()
    {
        $em = $this->getContainer()->get('doctrine')->getManager('limetrail');

        $today = new \DateTime(date('Y-m-d'));

        $theFuture = clone $today;
        $theFuture->add(new \DateInterval('P145D'));

        $days = clone $today;
        $days->add(new \DateInterval('P140D'));

        $query = $em->createQuery(
          'SELECT
              u.email, u.id
            FROM LimeTrail\Bundle\Entity\ProjectInformation pi
            INNER JOIN pi.contacts pc
            INNER JOIN pc.contact u
            INNER JOIN pc.jobrole j
            WHERE
              j.jobRole = ?1
            GROUP BY u.email'
          )
          ->setParameters(
            array(
              '1' => 'RHA Project Manager',
            )
          )
        ;

        $emails = $query->getArrayResult();

        foreach ($emails as $email) {
            $query = $em->createQuery(
          'SELECT CONCAT(CONCAT(si.storeNumber, \'-\'), pi.Sequence) AS number,
              pi.id,
              pi.canonicalName,
              d.pwoPrj,
              st.name AS type
            FROM LimeTrail\Bundle\Entity\StoreInformation si
            LEFT JOIN si.projects pi
            LEFT JOIN pi.ProjectStatus ps
            INNER JOIN pi.dates d
            LEFT JOIN si.storeType st
            INNER JOIN pi.contacts pc
            INNER JOIN pc.contact u
            WHERE
              ps.name = :status
              AND d.runDate = :today
              AND d.possPrj <= :thefuture
              AND d.possPrj >= :days
              AND u.id = :userId
            ORDER BY d.pwoPrj DESC'
          )
          ->setParameter(':status', 'Active')
          ->setParameter(':userId', $email['id'])
          ->setParameter(':today', $today, \Doctrine\DBAL\Types\Type::DATETIME)
          ->setParameter(':thefuture', $theFuture, \Doctrine\DBAL\Types\Type::DATETIME)
          ->setParameter(':days', $days, \Doctrine\DBAL\Types\Type::DATETIME)
          ;

            $result = $query->getArrayResult();

            if (!empty($result)) {
                $body = 'I found some stores which should have Final shells completed for them.  You might want to double check.';

                $message = \Swift_Message::newInstance()
              ->setSubject('Stores with approaching final shells due')
              ->setFrom(array('noreply@rhaaia.com' => 'RHA Web Robot'))
              ->setTo($email['email'])
              ->setBody(
                $this->getContainer()->get('templating')->render(
                  'LimeTrailBundle:Email:shelldue.email.html.twig',
                  array(
                    'result' => $result,
                    'body_message' => $body,
                  )
                ), 'text/html'
              );
                $message->addPart($this->getContainer()->get('templating')->render(
                  'LimeTrailBundle:Email:shelldue.email.txt.twig',
                  array(
                    'result' => $result,
                    'body_message' => $body,
                  )
                ), 'text/plain'
              );

                $this->getContainer()->get('mailer')->send($message);
            }
        }
    }

    private function array_flatten($array, $preserveKeys = 1, $newArray = array())
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $newArray = $this->array_flatten($value, $preserveKeys, $newArray);
            } elseif ($preserveKeys + is_string($key) > 1) {
                $newArray[] = $value;
            } else {
                $newArray[] = $value;
            }
        }

        return $newArray;
    }
}
