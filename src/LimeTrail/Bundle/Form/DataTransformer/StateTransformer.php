<?php

namespace LimeTrail\Bundle\Form\DataTransformer;

use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Provider\StateProvider;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms
 */
class StateTransformer implements DataTransformerInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            throw new UnexpectedTypeException($value, 'string');
            $qb = $this->objectManager('limetrail')->getRepository('LimeTrailBundle:State')->createQueryBuilder('s');

            $qb->select('s.name');

            return $qb->getQuery()->getArrayResult();
        }

        if (!$value instanceof State) {
            throw new UnexpectedTypeException($value, 'LimeTrail\Bundle\Entity\State');
        }

        return $value->getName();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $provider = new StateProvider(null, $this->objectManager);

        $state = $provider->getState($value);

        if ($state === null) {
            throw new TransformationFailedException(
            sprintf('the state with name "%s" doesn\'t exist', $value)
            );
        }

        return $state;
    }
}
