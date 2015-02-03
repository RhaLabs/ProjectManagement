<?php
// src/LimeTrail/SecurityBundle/Controller/SecurityController.php
namespace LimeTrail\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Security controller.
 *
 *
 */
class SecurityController extends Controller
{
    /**
     * login.
     *
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get login error if occurrs
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                        SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
               'LimeTrailSecurityBundle:Security:login.html.twig',
               array(
               // get the last username enter by user
               'last_username' => $session->get(SecurityContext::LAST_USERNAME),
               'error'         => $error,
               )
        );
    }
}
