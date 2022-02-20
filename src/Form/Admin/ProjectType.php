<?php

namespace App\Form\Admin;

use App\Entity\Project;
use App\Entity\Stack;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('slug', TextType::class, [
                'label' => 'Permalien du projet',
                'required' => false,
            ])
            ->add('visibility', ChoiceType::class, [
                'label' => 'Visibilité du projet',
                'multiple' => false,
                'expanded' => false,
                'choices' => Project::visibilities(),
            ])
            ->add('tasks', CollectionType::class, [
                'label' => 'Les tâches',
                'label_attr' => [
                    'style' => 'width:auto !important;',
                    'class' => 'mb-2 me-3',
                ],
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
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('uploadedFile', FileType::class, [
                'label' => 'Image du contenu',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the image file
                // every time you edit the Product details
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Cette image n\'est pas valide !',
                    ]),
                ],
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
