<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => ['placeholder' => 'Saisissez votre prénom'],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
            ])
            ->add('lastname' , TextType::class, [
                'label' => 'Votre nom',
                'attr' => ['placeholder' => 'Saisissez votre nom'],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),

            ])
            ->add('email', EmailType::class, [
                'label' => 'Vore email',
                'attr' => ['placeholder' =>'saisissez votre email '],

            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'le mot de passe et la confirmation ne sont pas identiques',
                'label' => 'Vore mot de passe',
                'required' => true,
                'first_options' => ['label' =>'Mot de passe',
                                     'attr' => ['placeholder' => 'saisissez votre mot de passe']],
                'second_options' => ['label' => 'confirmez votre mot de passe',
                    'attr' => ['placeholder' => 'confirmez votre mot de passe']],


            ])

            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
