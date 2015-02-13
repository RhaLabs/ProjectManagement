<?php
namespace LimeTrail\Bundle\Provider;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LimeTrail\Bundle\Entity\Company;
use LimeTrail\Bundle\Entity\Office;
use LimeTrail\Bundle\Entity\Address;

class CompanyProvider
{
    protected $em;

    protected $provider;

    protected $repository;

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
       $this->repository = $em->getRepository('LimeTrailBundle:Company');
   }

    public function getCompany($name)
    {
        $t = $this->repository->findByName($name);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getCompanyById($id)
    {
        $t = $this->repository->findById($id);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getAllCompanies()
    {
        $t = $this->repository->findAll();

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getCompanyByPartialName($partial)
    {
        $t = $this->repository->getCompanyByPartialName($partial);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function createCompany($name)
    {
        $company = $this->provider->createNewEntity('Company', $name);

        return $company;
    }

    public function createOffice($company)
    {
        $office = new Office();

        $company->setOffice($office);

        $this->em->persist($company);
        $this->em->persist($office);

        return $office;
    }

    public function getOffices($company)
    {
        $t = $company->getOffices();

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getOfficeByAddress(\LimeTrail\Bundle\Entity\Company $company, $address)
    {
        $offices = $company->getOffices($company);

        $result = $this->provider->findInResult($offices, 'address', $address);

        if (!$result || $result->isEmpty()) {
            return;
        } else {
            return $result->first();
        }
    }

    public function getOfficeByPhone(\LimeTrail\Bundle\Entity\Company $company, $mainPhone)
    {
        $offices = $company->getOffices($company);

        $result = $this->provider->findInResult($offices, 'mainPhone', $mainPhone);

        if (!$result || $result->isEmpty()) {
            return;
        } else {
            return $result->first();
        }

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getOfficeById($id)
    {
        $t = $this->em->getRepository('LimeTrailBundle:Office')->findOneById($id);

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
