<?php

namespace App\Form;

use App\Entity\Depense;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DepenseType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Designation',TextType::class, $this->conf('Désignation ','Tapez ici la désingation'))
            ->add('Qte',IntegerType::class, $this->conf('Quantité ','Qté ',[
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Quantité',
                    'min'=>1,
                    'max'=>99999,
                    'step'=>0000000000000000
                    ]
                ]))
            ->add('PrixUnitaire',IntegerType::class, $this->conf('Prix Unitaire','P.U ',[
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Prix Unitaire',
                    'min'=>100,
                    'max'=>9999999999999999,
                    'step'=>0000000000000000
                    ]
                ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depense::class,
        ]);
    }
}
