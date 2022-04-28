<?php

namespace App\Form;

use App\Entity\Cmd;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CmdType extends AbstractType
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
            ->add('designation',TextType::class, $this->configuration('Désignation ','Tapez ici la désingation du client'))
            ->add('periode',TextType::class,$this->configuration('Période ','La période du commande'))
            ->add('duree',TextType::class, $this->configuration('Durée ','la durée'))
            ->add('quantite',TextType::class, $this->configuration('Qunatité ','Tapez ici la quantité commander'))
            ->add('prixunitaire',TextType::class, $this->configuration(' Prix Unitaire','Le prix unitaire '))
            ->add('datecmd',DateType::class,$this->configuration(' Date du commande','date '))
            ->add('clientcmd', TextType::class,$this->configuration('Client',' Nom du client'));
            // ->add('clientcmd', EntityType::class,[
            //     'class' => Client::class,
            //     'label' => ' N° Facture',
            //     'placeholder' => 'Veuillez sélectionner',
            //     'query_builder'=>function(ClientRepository $Client){
            //         // return $client->createQueryBuilder('f')->select('f.nomcl')->orderBy('f.id');
            //         return $Client->createQueryBuilder('f')->select('f.nomcl')->orderBy('f.id','ASC');
            //     // 'query_builder'=>function(ClientRepository $Client){
            //     //     return $client->createQueryBuilder('f')->select('f.id') ->orderBy('f.id','ASC');
            // }]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cmd::class,
        ]);
    }
}
