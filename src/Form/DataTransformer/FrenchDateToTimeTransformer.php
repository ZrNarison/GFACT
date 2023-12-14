<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchDateToTimeTransformer implements DataTransformerInterface{
    public function transform($date){
        if($date === null){
            return '';
        }
        return $date->format('d/m/Y');
    }
    public function reverseTransform($FrenchDate){
        if($date === null){
             //Exception
            throw new TransformationFailedException("Merci de vérifier la date !");
        }
        $date = DateTime::createFromFormat('d/m/Y',$FrenchDate);
        if($date === false){
            //Exception
            throw new TransformationFailedException("Merci de vérifier le format de la date !");
        }
        return $date;
    }
}