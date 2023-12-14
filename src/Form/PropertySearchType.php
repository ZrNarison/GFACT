<?php

namespace App\Form;

use App\Entity\Cmd;
use App\Entity\CmdClient;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomClient',EntityType::class,[
                'class'=>CmdClient::class,
                "required"=> true,
                "label"=>false,
                "placeholder"=> "Merci de selectionner un client",
                'mapped'=>false
            ])
            ->add('DateCmd',DateType::class,[
                "required"=> true,
                "label"=>false,
                "attr"=>[
                    "placeholder"=> "Date",
                    
                ],"widget"=>"single_text"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
