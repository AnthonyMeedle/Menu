<?php

declare(strict_types=1);

namespace Menu\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

final class MenuForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add('title', TextType::class, [
                'label' => 'Nom du menu',
                'constraints' => [new NotBlank(), new Length(max: 255)],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description interne',
                'required' => false,
                'attr' => ['rows' => 2],
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Menu actif',
                'required' => false,
            ]);
    }
}
