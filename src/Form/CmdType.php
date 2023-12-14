<?php

namespace App\Form;

use App\Entity\Cmd;
use App\Form\AppType;
use App\Entity\CmdClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchDateToTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CmdType extends AppType
{
    private $transformer;
    public function __construct(FrenchDateToTimeTransformer $transformer){
        $this-> transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cmdClient',EntityType::class,[
                'class'=>CmdClient::class,
                'label'=>'Client',
                'placeholder' => "Veuillez séléctionner un client"
                ])
            ->add('Design',TextType::class, $this->conf('Désignation ','Tapez ici la désingation du client'))
            ->add('prd',TextType::class,$this->conf('Période ','La période du commande',['required'=>false]))
            ->add('duree',TextType::class, $this->conf('Durée ','la durée',['required'=>false]))
            ->add('Qte',IntegerType::class, $this->conf('Quantité ','Qté ',[
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Quantité',
                    'min'=>1,
                    'max'=>99999,
                    'step'=>0000000000000000
                    ]
                ]))
            ->add('Pu',IntegerType::class, $this->conf('Prix Unitaire','P.U ',[
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Prix Unitaire',
                    'min'=>1000,
                    'max'=>9999999999999999,
                    'step'=>0000000000000000
                    ]
                ]))
            // ->add('DtCmd',DateType::class,$this->conf("Date de commande :","Date de commande",["widget"=>"single_text"]))
            // ->add('DtCmd',DateType::class,$this->conf('Date du commande','date ',["mapped" => false,"widget"=>"single_text"]))
            
        ;
        //  $builder->get('DtCmd')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cmd::class,
        ]);
    }
}
