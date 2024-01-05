<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FiltreType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDps',DateType::class,[
                "required"=> true,
                "label"=>false,
                "attr"=>[
                    "placeholder"=> "Date",
                ],"widget"=>"single_text"
            ])
            ->add('Datefin',DateType::class,[
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
