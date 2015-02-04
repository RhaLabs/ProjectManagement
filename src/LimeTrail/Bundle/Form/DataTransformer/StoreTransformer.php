<?php

namespace LimeTrail\Bundle\Form\DataTransformer;

use LimeTrail\Bundle\Entity\StoreInformation;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms a store number to a store information.
 */
class StoreTransformer implements DataTransformerInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return 0;
        }

        if (!$value instanceof StoreInformation) {
            throw new UnexpectedTypeException($value, 'LimeTrail\Bundle\Entity\StoreInformation');
        }

        return $value->getStoreNumber();
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return new StoreInformation();
        }

        if (!is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'integer');
        }

        $store = $this->objectManager
            ->getRepository('LimeTrailBundle:StoreInformation')
            ->findOneBy(array(
                'storenumber' => $value,
            ));

        if ($store === null) {
            throw new TransformationFailedException(
            sprintf('the store number "%s" doesn\'t exist', $value)
            );
        }

        return $store;
    }
}
