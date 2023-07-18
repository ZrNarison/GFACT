<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\Params;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ParamsType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Std',TextType::class, $this->conf('Nom du station ','Tapez ici le nom du station service'))
            ->add('Frq',TextType::class, $this->conf('Fréquance ','Tapez ici le nom du client'))
            ->add('PAdres',TextType::class, $this->conf('Adress ','Tapez ici le nom du client'))
            ->add('Bp',TextType::class, $this->conf('Boite Postal ','Tapez ici le nom du client'))
            ->add('Mail',EmailType::class, $this->conf('Email ','Tapez ici le nom du client'))
            ->add('Telp',TextType::class, $this->conf('Telephone ','Tapez ici le nom du client'))
            ->add('PNif',TextType::class, $this->conf("Numéro d'Identité Fiscal (NIF) ",'Tapez ici le nom du client'))
            ->add('PStat',TextType::class, $this->conf('STAT ','Tapez ici le nom du client'))
            ->add('PRib',TextType::class, $this->conf("Rélévé d'Identité Bancaire (RIB)" ,'Tapez ici le nom du client'))
            ->add('Tp',TextType::class, $this->conf('TP ','Tapez ici le nom du client'))
            ->add('FStd',TextType::class, $this->conf('Pied du page ','Tapez ici le nom du client'))
            // ->add('PSlug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Params::class,
        ]);
    }
}
