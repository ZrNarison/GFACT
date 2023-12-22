<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\CmdClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditcClientType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('NCmd',TextType::class, $this->conf('N° Commande : ',"Numéro de commande"))
            ->add('CClient',TextType::class, $this->conf('Client : ',"Nom du client"))
            ->add('Dos',TextType::class, $this->conf('N° Dossier : ',"Numéro du dossier"))
            ->add('Dif',TextType::class, $this->conf('Diffusion : ',"Diffusion "))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CmdClient::class,
        ]);
    }
}
