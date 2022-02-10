<?php

namespace App\Form\Docs;

use App\Entity\Page;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageCreateType extends AbstractType
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
            ->add('visibility', ChoiceType::class, [
                'label' => 'Visibilité',
                'multiple' => false,
                'expanded' => false,
                'choices' => Page::visibilities(),
                'preferred_choices' => function ($choice, $key, $value) {
                    // prefer options 'public'
                    return $choice === Page::VISIBILITY_PUBLIC;
                },
            ])
            ->add('content', CKEditorType::class, [
                'label' => false,
            ])
            ->add('sources')
            ->add('state', ChoiceType::class, [
                'label' => 'État de la page',
                'multiple' => false,
                'expanded' => false,
                'choices' => Page::states(),
                'preferred_choices' => function ($choice, $key, $value) {
                    // prefer options 'public'
                    return $choice === Page::STATE_PENDING;
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn-crm'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
