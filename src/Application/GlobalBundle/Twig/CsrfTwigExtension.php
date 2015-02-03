<?php

namespace Application\GlobalBundle\Twig;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfTokenManagerAdapter;

class CsrfTwigExtension extends \Twig_Extension
{
    protected $csrfProvider;

    protected $session;

    public function __construct(CsrfTokenManagerAdapter $csrfProvider, Session $session)
    {
        $this->csrfProvider = $csrfProvider;

        $this->session = $session;
    }

    public function getName()
    {
        return 'csrf_twig_extension';
    }

    public function getFunctions()
    {
        return array(
            'default_csrf_token' => new \Twig_Function_Method($this, 'getCsrfToken'),
        );
    }

    public function getCsrfToken()
    {
        return $this->csrfProvider->generateCsrfToken($this->session->getId());
    }
}
