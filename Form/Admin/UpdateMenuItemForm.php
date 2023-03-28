<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UpdateMenuItemForm extends BaseForm
{
    static function getName()
    {
        return "menu_item_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'menu_list',
                TextType::class,
                array(
                    'required'      => true
                )
            )
            ->add(
                'menu_id',
                TextType::class
            );
    }
}