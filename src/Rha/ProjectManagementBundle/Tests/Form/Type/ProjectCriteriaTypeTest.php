<?php

namespace Rha\ProjectManagementBundle\Tests\Controller;

use Rha\ProjectManagementBundle\Form\Type\ProjectCriteriaType;
use Rha\ProjectManagementBundle\Entity\ProjectCriteria;
use Symfony\Component\Form\Test\TypeTestCase;

class ProjectCriteriaTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
        'test' => 'test',
        'test2' => 'test2',
        );

        $type = new ProjectCriteriaType();
        $form = $this->factory->create($type);

        $object = new ProjectCriteria();
        $object->fromArray($formData);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children();

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
