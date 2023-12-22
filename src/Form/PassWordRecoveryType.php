<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AppType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PassWordRecoveryType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Pseudo',TextType::class, $this->conf("Utilisateur ","Tapez ici le nom d'utilisateur",['mapped'=> false]))
            ->add('newPassword',PasswordType::class,$this->conf("Mot de passe :", "Votre mot de passe"))
            ->add('confirmPassword',PasswordType::class,$this->conf("Confirmation de mot de passe :", "Veuillez confirmer votre mot de pass"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => User::class,
        ]);
    }
}
