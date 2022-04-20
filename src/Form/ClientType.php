<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{    
    private function configuration($label,$placeholder){
        return [
            'label'=>$label,
            'attr'=>[
                'placeholder'=>$placeholder
            ]
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomcl',TextType::class, $this->configuration('Nom ','Tapez ici le nom du client'))
            ->add('adress',TextType::class, $this->configuration('Adress :',"Son adress "))
            ->add('numtel',IntegerType::class, $this->configuration('Contact : ',"Numéro téléphone"));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
