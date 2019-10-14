<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'the first name.',
                ],
            ])
            ->add('lastName')
            ->add('birthDay')
            ->add('address')
            ->add('city')
            ->add('email')
            ->add('mobileNumber')
            //->add('customer',CustomerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'allow_extra_fields'=>true,
            'csrf_protection' => false
        ]);
    }
}
