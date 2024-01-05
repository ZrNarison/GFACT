<?php

namespace App\Controller;

use DateTime;
use App\Entity\Depense;
use App\Form\FiltreType;
use App\Form\DepenseType;
use App\Form\EditDpsType;
use Cocur\Slugify\Slugify;
use App\Entity\PropertySearch;
use App\Repository\DepenseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/AdDepense/", name="depense")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function index(DepenseRepository $Depense,Request $rqt): Response
    {
        $limite = 8;
        $newdepense = new Depense();
        $date = new DateTime();
        $search = new PropertySearch();
        $filtre = $this -> createForm(FiltreType::class,$search);
        $form = $this -> createForm(DepenseType::class,$newdepense);
        $form ->handleRequest($rqt);
        $filtre ->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $slugify = new Slugify();
            $design= $slugify ->slugify($newdepense->getDesignation());
            $slug=$newdepense->getQte()."-".$design."-".$newdepense->getPrixUnitaire()."-".$date->Format("d-m-Y");
            $mng = $this -> getDoctrine()->getManager();
            $newdepense->setDateDps($date)
                    ->setSlug($slug);
            $mng -> persist($newdepense);
            $mng -> flush();           
            return $this->redirectToRoute('depense');
        }
        if($filtre->isSubmitted()&& $filtre->isValid()){
            $Depense=$Depense->findBy(['DateDps'=> $search->getDateDps()],['DateDps'=> $search->getDateFin()] ); 
               dd($Depense);
               return $this->render('home/index.html.twig', [
                "Depense"=>$Depense,
                "search"=>$search,
                'form'=> $form->createView(),            
                'filtre'=> $filtre->createView()
            ]);
        }
        $Depense=$Depense->findBy([],[],$limite,0); 
        return $this->render('home/index.html.twig', [
            "Depense"=>$Depense,
            "search"=>$search,
            'form'=> $form->createView(),            
            'filtre'=> $filtre->createView()
        ]);
    }

    /**
     * @Route("/EditDepense/{slug}/", name="editdps")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function editdepense(string $slug,DepenseRepository $Depense,Request $rqt)
    {
        $limite = 8;
        $date = new DateTime();
        $search = new PropertySearch();
        $newdepense =$depense=$Depense->findOneBy(['Slug'=>$slug]);
        $form = $this -> createForm(DepenseType::class,$newdepense);
        $filtre = $this -> createForm(FiltreType::class,$search);
        $form ->handleRequest($rqt);
        $filtre ->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $slugify = new Slugify();
            $design= $slugify ->slugify($newdepense->getDesignation());
            $slug=$newdepense->getQte()."-".$design."-".$newdepense->getPrixUnitaire()."-".$date->Format("d-m-Y");
            $mng = $this -> getDoctrine()->getManager();
            $newdepense->setDateDps($date)
                    ->setSlug($slug);
            $mng -> persist($newdepense);
            $mng -> flush();           
            return $this->redirectToRoute('depense');
        }
        $Depense=$Depense->findBy([],[],$limite,0); 
        return $this->render('new/index.html.twig', [
            "Depense"=>$Depense,
            "newdepense"=>$newdepense,
            "search"=>$search,
            'form'=> $form->createView(),
            'filtre'=> $filtre->createView()
        ]);
    }

    /**
     * @Route("/deldepense{slug}/", name="deldepense")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function deldepense(string $slug,DepenseRepository $Depense,Request $rqt): Response
    {
        $Depense=$Depense->findOneBy(['id'=>$slug]);
        $mgr = $this -> getDoctrine()->getManager();
        $mgr->remove($Depense);
        $mgr->flush();
        return $this->redirectToRoute('depense');
    }
}
