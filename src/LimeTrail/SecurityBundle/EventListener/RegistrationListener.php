<?php

namespace LimeTrail\SecurityBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /*
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array( FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize');
    }

    public function onRegistrationInitialize(FormEvent $event)
    {
        $url = $this->router->generate('homepage');
        $event->setResponse(new RedirectResponse($url));
    }
}
