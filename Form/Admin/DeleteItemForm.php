<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Form\BaseForm;

class DeleteItemForm extends BaseForm
{
    static public function getName()
    {
        return "menu_delete_item";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'item_id',
                TextType::class,
                array(
                    'required'      => true
                )
            );
    }
}