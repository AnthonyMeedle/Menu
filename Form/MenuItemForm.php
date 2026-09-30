<?php

declare(strict_types=1);

namespace Menu\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Thelia\Form\BaseForm;

final class MenuItemForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add('target', HiddenType::class)
            ->add('parent_id', HiddenType::class, ['required' => false, 'empty_data' => '0'])
            ->add('title', TextType::class, [
                'label' => 'Titre personnalisé',
                'required' => false,
                'help' => 'Obligatoire pour un lien libre. Laissez vide pour reprendre le titre de la destination.',
                'constraints' => [new Length(max: 255)],
            ])
            ->add('url', TextType::class, [
                'label' => 'URL personnalisée',
                'required' => false,
                'help' => 'Accepte une URL absolue, une ancre ou un chemin comme /contact.',
                'constraints' => [new Length(max: 2048)],
            ])
            ->add('chapo', TextareaType::class, [
                'label' => 'Texte court',
                'required' => false,
                'attr' => ['rows' => 2],
            ])
            ->add('css_class', TextType::class, [
                'label' => 'Classe CSS',
                'required' => false,
                'constraints' => [new Length(max: 255)],
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icône',
                'required' => false,
                'help' => 'Exemple : bi bi-house.',
                'constraints' => [new Length(max: 255)],
            ])
            ->add('target_blank', CheckboxType::class, [
                'label' => 'Ouvrir dans un nouvel onglet',
                'required' => false,
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Élément visible',
                'required' => false,
            ]);
    }
}
