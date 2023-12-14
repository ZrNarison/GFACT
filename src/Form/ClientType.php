<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\Client;
use App\Form\CmdClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ClientType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomCl',TextType::class, $this->conf('Nom ','Tapez ici le nom du client'))
            ->add('Adress',TextType::class, $this->conf('Adress ','Son adress',['required'=>false]))
            ->add('Tel',TextType::class, $this->conf('Contact ','Son contact telephonique',['required'=>false]))
            ->add('Stat',IntegerType::class, $this->conf('STAT ','Numéro du Carte Statistique',[
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Numéro du Carte Statistique',
                    'min'=>0000000000000001,
                    'max'=>9999999999999999,
                    'step'=>0000000000000000
                    ]
                ]))
            ->add('Nif',IntegerType::class, $this->conf("NIF","Numéro d'Identité Fiscal (NIF)",[
                'required'=>false,
                'attr'=>[
                    'placeholder'=>"Numéro d'Identité Fiscal (NIF)",
                    'min'=>1,
                    'max'=>9999999999999999,
                    'step'=>0000000000000000
                    ]
                ]))
            ->add('Rcs',TextType::class, $this->conf('RCS ','Numere du carte RCS',['required'=>false]))
            ->add('RIB',TextType::class, $this->conf('RIB ',"Numéro d'Identité Bancaire",['required'=>false]))
            ->add('NCmd',NumberType::class, $this->conf('N° Commande : ',"Numéro de commande",['mapped'=>false,'required'=>false]))
            ->add('CClient',TextType::class, $this->conf('Client : ',"Nom du client",['mapped'=>false,'required'=>false]))
            ->add('Dos',NumberType::class, $this->conf('N° Dossier : ',"Numéro du dossier",['mapped'=>false,'required'=>false]))
            ->add('Dif',TextType::class, $this->conf('Diffusion : ',"Diffusion ",['mapped'=>false,'required'=>false]))
            // ->add('Client',
            //     CollectionType::class,
            //     [
            //         'entry_type'=>CmdClientType::class
            //     ]
            // )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
