<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Thelia\Form\BaseForm;

class UpdateMenuItemDetailsForm extends BaseForm
{
    static public function getName()
    {
        return "menu_item_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'item_id',
                TextType::class
            )
            ->add(
                'title',
                TextType::class
            )
            ->add(
                'chapo',
                TextType::class
            )
            ->add(
                'url',
                TextType::class
            )
            ->add(
                'cssclass',
                TextType::class
            )
            ->add(
                'targetblank',
                CheckboxType::class
            )
            ->add(
                'sousmenu',
                CheckboxType::class
            )
            ->add(
                'icone',
                TextType::class
            );
    }
}