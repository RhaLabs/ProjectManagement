<?php
namespace Application\Sonata\UserBundle\EventListener;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PasswordChangeListener implements EventSubscriberInterface {

    private $tokenStorage;
    
    private $userManager;
    
    public function __construct(TokenStorageInterface $tokenStorage, UserManager $userManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
                    FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordChangeSuccess',
                    FOSUserEvents::RESETTING_RESET_INITIALIZE => 'onPasswordChangeInit',
                );
    }
    
    public function onPasswordChangeSucces(FormEvent $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        
        if ($user->hasRole('ROLE_FORCEPASSWORDCHANGE')) {
            $user->removeRole('ROLE_FORCEPASSWORDCHANGE');
            
            $this->userManager->updateUser($user);
        }
    }
    
    public function onPasswordChangeInit(GetResponseUserEvent $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        
        if ($user->hasRole('ROLE_FORCEPASSWORDCHANGE')) {
            $user->setEncoderName('default');
            
            $this->userManager->updateUser($user);
        }
    }
}
