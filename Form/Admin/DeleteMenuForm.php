<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DeleteMenuForm extends BaseForm
{
    static function getName()
    {
        return "menu_delete_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'menu_id',
                TextType::class,
                array(
                    'required'      => true
                )
            );
    }
}