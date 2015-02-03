<?php

namespace Application\Sonata\UserBundle\Security;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class LegacyEncoder extends BasePasswordEncoder
{
    public function encodePassword($raw, $salt)
    {
        $sha = new MessageDigestPasswordEncoder('sha512');
        
        return $sha->encodePassword($raw, $salt);
    }
    
    public function isPasswordValid($encoded, $raw, $salt)
    {
        $sha = new MessageDigestPasswordEncoder('sha512');
        
        $isValid = $sha->isPasswordValid($encoded, $raw, $salt);
        
        return $isValid;
    }
} 
