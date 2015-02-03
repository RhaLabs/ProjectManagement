<?php

namespace Rha\ProjectManagementBundle\Form\DataTransformer;

use Rha\ProjectManagementBundle\Entity\ProjectInformation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms
 */
class ProjectTransformer implements DataTransformerInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return;
        }

        if (!$value instanceof ProjectInformation) {
            throw new UnexpectedTypeException($value, 'Rha\ProjectManagementBundle\Entity\ProjectInformation');
        }

        return $value->getProjectNumber();
    }

    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $project = $this->entityManager
            ->getRepository('Rha\ProjectManagementBundle\Entity\ProjectInformation')
            ->findOneBy(array(
                'projectNumber' => $value,
            ));

        if (null === $project) {
            throw new TransformationFailedException(sprintf(
            'A project with project number "%s" was not found',
            $value)
          );
        }

        return $project;
    }
}
