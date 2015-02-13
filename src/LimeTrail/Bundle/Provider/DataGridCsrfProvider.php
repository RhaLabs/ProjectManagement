<?php
namespace LimeTrail\Bundle\Provider;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfTokenManagerAdapter;

class DataGridCsrfProvider
{
    protected $request;

    protected $requestStack;

    protected $session;

    protected $csrfProvider;

   /**
    * Construct
    *
    * @param ContainerInterface $container
    * @param array $dataGridIds
    */
   public function __construct(RequestStack $requestStack)
   {
       $this->requestStack = $requestStack;

       $this->request = $this->requestStack->getCurrentRequest();
   }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function setCsrfProvider(CsrfTokenManagerAdapter $csrf)
    {
        $this->csrfProvider = $csrf;
    }

    public function ValidateGridToken()
    {
        $token = $this->request->get('__token');

        $sessionId = $this->session->getId();

        return $this->csrfProvider->isCsrfTokenValid($sessionId, $token);
    }
}
