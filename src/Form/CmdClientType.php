<?php

namespace App\Form;

use App\Entity\Cmdclient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmdClientType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NCmd',TextType::class, $this->conf('N° Commande : ',"Numéro de commande",['required'=>false]))
            ->add('CClient',TextType::class, $this->conf('Client : ',"Nom du client",['required'=>false]))
            ->add('Dos',TextType::class, $this->conf('N° Dossier : ',"Numéro du dossier",['required'=>false]))
            ->add('Dif',TextType::class, $this->conf('Diffusion : ',"Diffusion ",['required'=>false]));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cmdclient::class,
        ]);
    }
}
