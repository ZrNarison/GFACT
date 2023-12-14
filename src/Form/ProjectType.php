<?php

namespace App\Form;

use App\Form\AppType;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title',TextType::class, $this->conf("Nom ","Nom de l'application"))
            ->add('Version',TextType::class, $this->conf("Version ","Version"))
            ->add('DateSortie',DateType::class, $this->conf("Sortie le ",'date ',["widget"=>"single_text"]))
            ->add('fichiers',FileType::class,$this->conf("fichier :", "Veuillez sélectionner votre logiciel"),['mapped'=>false])
            ->add('Description',TextareaType::class, $this->conf("Description ","Description"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
