<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\Params;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ParamsEditType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Std',TextType::class, $this->conf('Nom du station ','Tapez ici le nom du station service'))
        ->add('Frq',TextType::class, $this->conf('Fréquance ','Tapez ici le frequence'))
        ->add('PAdres',TextType::class, $this->conf('Adress ',"Tapez ici l'adress"))
        ->add('Bp',TextType::class, $this->conf('Boite Postal ','Tapez ici le nom du client',['required'=>false]))
        ->add('Mail',EmailType::class, $this->conf('Email ',"Tapez ici l'adresse email"))
        ->add('Telp',TextType::class, $this->conf('Telephone ','Tapez ici le contact'))
        ->add('PNif',TextType::class, $this->conf("Numéro d'Identité Fiscal (NIF) ","Numéro d'Identité Fiscal (NIF)"))
        ->add('PStat',TextType::class, $this->conf('STAT ','Tapez ici le numero STAT'))
        ->add('PRib',TextType::class, $this->conf("Rélévé d'Identité Bancaire (RIB)" ,"Rélévé d'Identité Bancaire (RIB)",['required'=>false]))
        ->add('Tp',TextType::class, $this->conf('TP ','Tapez ici le TP',['required'=>false]))
        ->add('FStd',TextType::class, $this->conf('Pied du page ',"Texte notez au pied de page",['required'=>false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Params::class,
        ]);
    }
}
