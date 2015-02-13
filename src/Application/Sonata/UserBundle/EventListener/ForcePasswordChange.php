<?php

namespace Application\Sonata\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Service("request.set_messages_count_listener")
 *
 */
class ForcePasswordChange
{

  private $tokenStorage;
    private $checker;
    private $session;
    private $router;
    private static $role = 'ROLE_FORCEPASSWORDCHANGE';

    public function __construct(TokenStorageInterface $tokenStorage,
                              AuthorizationChecker $checker,
                              Session $session,
                              Router $router)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->session          = $session;
        $this->checker          = $checker;
        $this->router           = $router;
    }

    public function onCheckStatus(GetResponseEvent $event)
    {
        if (($this->tokenStorage->getToken()) && ($this->checker->isGranted('IS_AUTHENTICATED_FULLY'))) {
            $route = $event->getRequest()->get('_route');

            if ($route !== 'fos_user_change_password' && $route !== '_wdt') {
                $user = $this->tokenStorage->getToken()->getUser();

                if ($user->hasRole(self::$role)) {
                    $response = new RedirectResponse($this->router->generate('fos_user_change_password'));

                    $this->session->getFlashBag()->add('notice', 'We\'ve updated our web server\'s security so you need to change or re-enter your password.');

                    $event->setResponse($response);
                }
            }
        }
    }
}
