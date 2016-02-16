<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class AddMenuForm extends BaseForm
{
    public function getName()
    {
        return "menu_add_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'title',
                'text',
                array(
                    'required'      => true
                )
            )
            ->add(
                'description',
                'text'
            );
    }
}