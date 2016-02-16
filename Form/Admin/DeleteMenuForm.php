<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class DeleteMenuForm extends BaseForm
{
    public function getName()
    {
        return "menu_delete_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'menu_id',
                'text',
                array(
                    'required'      => true
                )
            );
    }
}