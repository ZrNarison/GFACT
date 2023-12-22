<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModClientType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomCl')
            ->add('Adress')
            ->add('Tel')
            ->add('Stat')
            ->add('Nif')
            ->add('Rcs')
            ->add('RIB')
            ->add('Slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
