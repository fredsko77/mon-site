<?php

namespace App\Form\Docs;

use App\Entity\Shelf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ShelfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nouvelle étagère'],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 4],
                'required' => false,
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
            ->add('slug', TextType::class, [
                'label' => 'Permalien',
                'required' => false,
            ])
            ->add('visibility', ChoiceType::class, [
                'label' => 'Visibilité',
                'multiple' => false,
                'expanded' => false,
                'choices' => Shelf::visibilities(),
                'preferred_choices' => function ($choice, $key, $value) {
                    // prefer options 'public'
                    return $choice === Shelf::VISIBILITY_PUBLIC;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shelf::class,
        ]);
    }
}
