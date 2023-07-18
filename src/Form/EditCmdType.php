<?php

namespace App\Form;

use App\Entity\Cmd;
use App\Form\AppType;
use App\Entity\CmdClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EditCmdType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Design',TextType::class, $this->conf('Désignation ','Tapez ici la désingation du client'))
            ->add('prd',TextType::class,$this->conf('Période ','La période du commande'))
            ->add('duree',TextType::class, $this->conf('Durée ','la durée'))
            ->add('Qte',TextType::class, $this->conf('Quantité ','Tapez ici la quantité commander'))
            ->add('Pu',TextType::class, $this->conf('Prix Unitaire','Le prix unitaire '))
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
