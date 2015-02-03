<?php
namespace LimeTrail\Bundle\Provider;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Entity\Contact;
use LimeTrail\Bundle\Entity\ProjectContacts;

class ContactProvider
{
    protected $em;

    protected $provider;

  /**
   * Construct
   *
   * @param ContainerInterface $container
   * @param array $dataGridIds
   */
   public function __construct(EntityProvider $provider, EntityManager $em)
   {
       $this->provider = $provider;
       $this->em = $em;
   }

  // @var $state must be a string
  public function getContact($firstname, $middlename, $lastname)
  {
      $q = $this->em->getRepository('LimeTrailBundle:Contact');

      $t = $q->findByFullName($firstname, $middlename, $lastname);

      if (!$t) {
          return;
      }

      return $t;
  }

    public function getContactByShortNameAndDomain($firstname, $lastname, $domain)
    {
        $q = $this->em->getRepository('LimeTrailBundle:Contact');

        $domain = '%'.$domain;

        $t = $q->findByShortNameAndDomain($firstname, $lastname, $domain);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function findAllContacts()
    {
        $q = $this->em->getRepository('LimeTrailBundle:Contact');

        return $q->findAll();
    }

    public function findContactById($id)
    {
        $q = $this->em->getRepository('LimeTrailBundle:Contact');

        $t = $q->findOneById($id);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getContactsByCompany($name)
    {
        $q = $this->em->getRepository('LimeTrailBundle:Contact');

        $t = $q->findByCompany($name);

        if (!$t) {
            return;
        }

        $collection = new \Doctrine\Common\Collections\ArrayCollection($t);

        return $collection;
    }

    public function createContact($params = array())
    {
        $contact = new Contact();

        foreach ($params as $key => $value) {
            $contact->{"set$key"}($value);
        }

        $this->em->persist($contact);

        return $contact;
    }

    public function updateContact($contact, $params = array())
    {
        foreach ($params as $key => $value) {
            $contact->{"set$key"}($value);
        }

        $this->em->persist($contact);

        return $contact;
    }

    public function findJobRole($jobrole)
    {
        $q = $this->em->getRepository('LimeTrailBundle:JobRole');

        $t = $q->findByJobRole($jobrole);

        if (!$t) {
            return;
        }

        return $t[0];
    }

    public function findJobRoleById($id)
    {
        $q = $this->em->getRepository('LimeTrailBundle:JobRole');

        $t = $q->findOneById($id);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function findAllJobRoles()
    {
        $q = $this->em->getRepository('LimeTrailBundle:JobRole');

        return $q->findAll();
    }

    public function findInResultsByName($array, $name)
    {
        $nameInParts = preg_split('~[\s,]+~', $name);

        foreach ($nameInParts as &$part) {
            $part = $this->formatNames(trim($part));
        }

        $lastNameResults = $this->provider->findInResult($array, 'lastName', $nameInParts[1]);

        $firstNameResults = $this->provider->findInResult($lastNameResults, 'firstName', $nameInParts[0]);

        if (method_exists($firstNameResults, 'first')) {
            return $firstNameResults->first();
        } else {
            return false;
        }
    }

    public function findProjectContact($project, $contact)
    {
        $q = $this->em->getRepository('LimeTrailBundle:ProjectContacts');

        $t = $q->findByProjectAndContact($project, $contact);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function findProjectContactById($id)
    {
        $q = $this->em->getRepository('LimeTrailBundle:ProjectContacts');

        $t = $q->findOneById($id);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function createProjectContact($project, $jobrole, $contact)
    {
        $projectcontact = new ProjectContacts();

        $projectcontact->addProject($project)
                   ->addJobRole($jobrole)
                   ->addContact($contact);

        $this->em->persist($projectcontact);

        return $projectcontact;
    }

    public function updateProjectContact($projectcontact, $jobrole)
    {
        $projectcontact->setJobRole($jobrole);

        $this->em->persist($projectcontact);

        return $projectcontact;
    }

    public function deleteProjectContact($projectcontact)
    {
        $this->em->remove($projectcontact);
    }

    public function formatNames($name)
    {
        $name = ucwords(strtolower($name));

        foreach (array('-', '\'', 'Mc') as $delimiter) {
            if (strpos($name, $delimiter) !== false) {
                $name = implode($delimiter, array_map('ucfirst', explode($delimiter, $name)));
            }
        }

        $parts = explode(' ', $name);

        foreach ($parts as &$part) {
            if (strlen($part) === 2) {
                $part = strtoupper($part);
            }
        }

        $name = implode(' ', $parts);

        return $name;
    }

    public function getProjectContactsFromProjectByJobRole($project, $jobrole)
    {
        $q = $this->em->getRepository('LimeTrailBundle:ProjectContacts');

        $t = $q->findAllByJobRole($project, $jobrole);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getProvider()
    {
        return $this->provider;
    }
}
