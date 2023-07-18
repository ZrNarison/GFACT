<?php

namespace App\Form;

use App\Entity\Cmd;
use App\Form\AppType;
use App\Entity\CmdClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CmdType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CmdClient',EntityType::class,[
                'mapped'=>false,
                'class'=>CmdClient::class,
                'label'=>'Client',
                'placeholder' => "Veuillez séléctionner un client"
                ])
            ->add('Design',TextType::class, $this->conf('Désignation ','Tapez ici la désingation du client'))
            ->add('prd',TextType::class,$this->conf('Période ','La période du commande'))
            ->add('duree',TextType::class, $this->conf('Durée ','la durée'))
            ->add('Qte',TextType::class, $this->conf('Quantité ','Qté '))
            ->add('Pu',TextType::class, $this->conf('Prix Unitaire','P.U '))
            ->add('DtCmd',DateType::class,$this->conf('Date du commande','date ',["widget"=>"single_text"]))
            // ->add('DtCmd',DateType::class,$this->conf('Date du commande','date ',["mapped" => false,"widget"=>"single_text"]))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cmd::class,
        ]);
    }
}
