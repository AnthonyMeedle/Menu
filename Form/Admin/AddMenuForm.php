<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddMenuForm extends BaseForm
{
    static function getName()
    {
        return "menu_add_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'title',
                TextType::class,
                array(
                    'required'      => true
                )
            )
            ->add(
                'objet',
                TextType::class
            )
            ->add(
                'typobj',
                TextType::class
            )
            ->add(
                'description',
                TextType::class
            );
    }
}