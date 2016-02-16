<?php

namespace RewriteUrl\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class Update404Form extends BaseForm
{
    public function getName()
    {
        return "rewriteurl_404_update_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'ids',
                'text',
                array(
                    'required'      => true
                )
            )
            ->add(
                'idss',
                'text',
                array(
                    'required'      => true
                )
            )
            ->add(
                'to',
                'text',
                array(
                    'constraints'   => array(new NotBlank()),
                    'required'      => true
                )
            );
    }
}