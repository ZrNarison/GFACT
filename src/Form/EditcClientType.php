<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\CmdClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EditcClientType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('NCmd',NumberType::class, $this->conf('N° Commande : ',"Numéro de commande",['mapped'=>false,'required'=>false]))
        ->add('CClient',TextType::class, $this->conf('Client : ',"Nom du client",['mapped'=>false,'required'=>false]))
        ->add('Dos',NumberType::class, $this->conf('N° Dossier : ',"Numéro du dossier",['mapped'=>false,'required'=>false]))
        ->add('Dif',TextType::class, $this->conf('Diffusion : ',"Diffusion ",['mapped'=>false,'required'=>false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CmdClient::class,
        ]);
    }
}
