<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'Nom complet',
                'required' => false,
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => true,
            ])
            ->add('isCompany', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Entreprise',
                'required' => false,
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Raison sociale',
                'row_attr' => [
                    'class' => 'hidden',
                    'id' => 'company-name-field',
                ],
                'required' => false,
            ])
            ->add('about', TextType::class, [
                'label' => 'Objet de votre message',
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => false,
                'data' => "Bonjour monsieur AGATHE, \n",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
