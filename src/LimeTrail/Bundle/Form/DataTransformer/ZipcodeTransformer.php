<?php

namespace LimeTrail\Bundle\Form\DataTransformer;

use LimeTrail\Bundle\Entity\Zip;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms an Invitation to an invitation code.
 */
class ZipcodeTransformer implements DataTransformerInterface
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

        if (!$value instanceof Zip) {
            throw new UnexpectedTypeException($value, 'LimeTrail\Bundle\Entity\Zip');
        }

        return $value->getZipcode();
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return new Zip();
        }

        if (!is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'integer');
        }

        $zip = $this->objectManager
            ->getRepository('LimeTrailBundle:Zip')
            ->findOneBy(array(
                'zipcode' => $value,
            ));

        if ($zip === null) {
            throw new TransformationFailedException(
            sprintf('the zipcode "%s" doesn\'t exist', $value)
            );
        }

        return $zip;
    }
}
