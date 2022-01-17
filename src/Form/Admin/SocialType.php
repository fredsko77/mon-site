<?php

namespace App\Form\Admin;

use App\Entity\Social;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du réseau social',
                'required' => true,
            ])
            ->add('link', TextType::class, [
                'label' => 'Url',
                'required' => true,
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icône',
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre du lien',
                'required' => true,
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Social::class,
        ]);
    }
}
