<?php

namespace Application\GlobalBundle\Form\DataTransformer;

use Application\Sonata\UserBundle\Entity\Invitation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms an Invitation to an invitation code.
 */
abstract class InvitationToCodeTransformer implements DataTransformerInterface
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

        if (!$value instanceof Invitation) {
            throw new UnexpectedTypeException($value, 'Application\Sonata\UserBundle\Entity\Invitation');
        }

        return $value->getCode();
    }

    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        return $this->entityManager
            ->getRepository('Application\Sonata\UserBundle\Entity\Invitation')
            ->findOneBy(array(
                'code' => $value,
                'user' => null,
            ));
    }
}
