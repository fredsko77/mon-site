<?php

namespace App\Form\Admin;

use App\Entity\GroupSkill;
use App\Form\Admin\SkillType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('icon', TextType::class, [
                'required' => false,
                'label' => 'Icône',
            ])
            ->add('color', ChoiceType::class, [
                'choices' => GroupSkill::listColor(),
                'label' => 'Couleur',
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('skills', CollectionType::class, [
                'label' => 'Compétences',
                'entry_type' => SkillType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'entry_options' => ['label' => false],
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupSkill::class,
        ]);
    }
}
