<?php

namespace Menu\Form\Admin;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class UpdateMenuItemForm extends BaseForm
{
    public function getName()
    {
        return "menu_item_form";
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'menu_list',
                'text',
                array(
                    'required'      => true
                )
            )
            ->add(
                'menu_id',
                'text'
            );
    }
}