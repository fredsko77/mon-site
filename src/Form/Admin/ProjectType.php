<?php

namespace App\Form\Admin;

use App\Entity\Project;
use App\Entity\Stack;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du projet',
            ])
            ->add('link', UrlType::class, [
                'label' => 'Url du projet',
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description du projet',
            ])
            ->add('state', ChoiceType::class, [
                'label' => 'État du projet',
                'multiple' => false,
                'expanded' => false,
                'choices' => Project::states(),
            ])
            ->add('slug')
            ->add('visibility', ChoiceType::class, [
                'label' => 'Visibilité du projet',
                'multiple' => false,
                'expanded' => false,
                'choices' => Project::visibilities(),
            ])
            ->add('tasks', CollectionType::class, [
                'label' => 'Les tâches',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'entry_options' => ['label' => false],
            ])
            ->add('stacks', EntityType::class, [
                'label' => 'Stack du projet',
                'class' => Stack::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
