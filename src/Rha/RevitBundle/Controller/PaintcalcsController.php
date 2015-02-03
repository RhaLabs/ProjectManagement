<?php

namespace Rha\RevitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Revitui controller.
 *
 * @Route("/paintcalcs")
 */
class PaintcalcsController extends Controller
{
    /**
     * @Route("/", name="rha_revit_paintcalcs")
     * @Template("RhaRevitBundle:Paintcalcs:paintcalcs.html.twig")
     * @Method("GET")
     */
    public function indexAction()
    {
        $data = array(
            'smooth' => 38304,
            'split' => 4777,
        );

        $form = $this->createExcelForm($data);

        return array(
          'excel_form' => $form->createView(),
        );
    }

    /**
     * @Route("/", name="rha_revit_paintcalcs_download")
     * @Template("RhaRevitBundle:Paintcalcs:paintcalcs.html.twig")
     * @Method("PUT")
     */
    public function downloadAction(Request $request)
    {
        $data = array(
            'smooth' => 38304,
            'split' => 4777,
        );

        $form = $this->createExcelForm($data);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $phpExcelObject = $this->get('phpexcel')
            ->createPHPExcelObject('bundles/rharevit/docs/CMU_Block_and_paint_areas.xls');
            $phpExcelObject->setActiveSheetIndex(1)
              ->setCellValue('G7', $data['smooth'])
              ->setCellValue('G9', $data['split'])
              ->setCellValue('G11', $data['smooth'])
              ->setCellValue('G13', $data['split']);
            $writer = $this->get('phpexcel')
            ->createWriter($phpExcelObject, 'Excel5');
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            $d = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'CMU_Block_and_paint_areas.xls'
          );

            $response->headers->set('Content-Disposition', $d);

            return $response;
        }

        return array(
          'excel_form' => $form->createView(),
        );
    }

    private function createExcelForm($data)
    {
        $form = $this->createFormBuilder($data, array(
          'action' => $this->generateUrl("rha_revit_paintcalcs"),
          'method' => 'PUT',
      ))
        ->add('smooth', 'integer')
        ->add('split', 'integer')
        ->add('Download', 'submit');

        return $form->getForm();
    }
}
