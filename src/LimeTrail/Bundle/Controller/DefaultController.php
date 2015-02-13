<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="limetrail_home")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('LimeTrailBundle:Default:index.html.twig');
    }

    /**
     * @Route("/_token", name="token")
     * @Template()
     * @Method("POST")
     */
    public function tokenAction()
    {
        $crsf = $this->get('form.csrf_provider');

        $session = $this->get('session');

        $token = $crsf->generateCsrfToken($session->getId());

        return new Response($token);
    }
    
    /**
     * @Route("/docs/{filename}", defaults={"filename" = "index.md"}, name="documentation")
     * @Template()
     */
    public function docAction($filename)
    {
        $docsFolder = __DIR__."/../Resources/doc/";
        
        $markdownFile = $docsFolder.$filename;
        
        if (file_exists($markdownFile)) {
            $colorized_xhtml = $this->get('markdown.parser')->transformMarkdown(file_get_contents($markdownFile));

            return array('markdown' => $colorized_xhtml);
        }
        
        throw new \Exception("nothing here");
    }
}
