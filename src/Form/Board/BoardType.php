<?php

namespace App\Form\Board;

use App\Entity\Board;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du tableau',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('deadline', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('defaultLists', CheckboxType::class, [
                'label' => 'Liste automatique',
                'mapped' => false,
                'required' => false,
            ])
            ->add('defaultTags', CheckboxType::class, [
                'label' => 'Etiquettes automatique',
                'mapped' => false,
                'required' => false,
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Board::class,
        ]);
    }
}
