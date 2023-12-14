<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AppType;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserType extends AppType
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo',TextType::class, $this->conf("Utilisateur ","Tapez ici le nom d'utilisateur"))
            ->add('picture',FileType::class,$this->conf("Photo :", "Veuillez sélectionner votre photo"),['mapped'=>false])
            // ->add('picture',FileType::class,['mapped'=>false,'label'=>'Photo'])
            ->add('mdp',PasswordType::class,$this->conf("Mot de passe :", "Votre mot de passe"))
            ->add('confirmation',PasswordType::class,$this->conf("Confirmation de mot de passe :", "Veuillez confirmer votre mot de pass"))
            ->add('class',EntityType::class,[
                'mapped'=>false,
                'class'=>Role::class,
                'choice_label'=>'Title',
                'placeholder' => "Veuillez séléction la class d'utilisateur",
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
