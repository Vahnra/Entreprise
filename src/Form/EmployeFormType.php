<?php

namespace App\Form;

use App\Entity\Employe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EmployeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname'
            )
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('gender', TextType::class, [
                'label' => 'Sexe'
            ])
            ->add('service', TextType::class, [
                'label' => 'Service'
            ])
            ->add('entryAt', DateType::class, [
                'label' => "Date d'embauche",
                'widget' => 'single_text'
            ])
            ->add('salary', TextType::class, [
                'label' => 'Salaire'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'validate' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
