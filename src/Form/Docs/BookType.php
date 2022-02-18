<?php

namespace App\Form\Docs;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => false,
            ])
            ->add('slug', TextType::class, [
                'label' => 'Permalien',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('visibility', ChoiceType::class, [
                'label' => 'Visibilité',
                'multiple' => false,
                'expanded' => false,
                'choices' => Book::visibilities(),
                'preferred_choices' => function ($choice, $key, $value) {
                    // prefer options 'public'
                    return $choice === Book::VISIBILITY_PUBLIC;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
