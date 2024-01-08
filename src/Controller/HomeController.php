<?php

namespace App\Controller;

use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\NFact;
use App\Entity\Depense;
use App\Form\FiltreType;
use App\Form\DepenseType;
use App\Form\EditDpsType;
use App\Entity\VeiewPrint;
use Cocur\Slugify\Slugify;
use App\Form\ViewPrintType;
use App\Entity\PropertySearch;
use App\Service\NumberConverter;
use App\Repository\CmdRepository;
use App\Repository\NFactRepository;
use App\Repository\ClientRepository;
use App\Repository\ParamsRepository;
use App\Controller\AccueilController;
use App\Repository\DepenseRepository;
use App\Repository\CmdClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
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
            // $slugify = new Slugify();
            // // $this->Slug = $this->Qte."-".$slugify->slugify($this->Designation).$this->PrixUnitaire."-".($this->DateDps)->Format("d-m-Y");
            // $Slug = $newdepense->getQte()."-".$slugify->slugify($newdepense->getDesignation())."-".$newdepense->PrixUnitaire()."-".($newdepense->DateDps())->Format("d-m-Y");
            $mng = $this -> getDoctrine()->getManager();
            $newdepense->setDateDps($date)
                        // ->setSlug($slug)
                        ;
            $mng -> persist($newdepense);
            $mng -> flush();           
            return $this->redirectToRoute('depense');
        }
        if($filtre->isSubmitted()&& $filtre->isValid()){
            $qb = $Depense->createQueryBuilder('d');
            $dateDpsString = $search->getDateDps()->format('Y-m-d');
            $dateFinString = $search->getDateFin()->format('Y-m-d');
            $Depense = $qb
                ->andwhere('d.DateDps >= :dateDps')
                ->andWhere('d.DateDps <= :dateFin')
                ->setParameter('dateDps', $dateDpsString)
                ->setParameter('dateFin', $dateFinString)
                ->getQuery()
                ->getResult();
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
            // $slugify = new Slugify();
            // $design= $slugify ->slugify($newdepense->getDesignation());
            // $slug=$newdepense->getQte()."-".$design."-".$newdepense->getPrixUnitaire()."-".$date->Format("d-m-Y");
            $mng = $this -> getDoctrine()->getManager();
            $newdepense->setDateDps($date);
                    // ->setSlug($slug);
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

    /**
     * @Route("/facture/{slug}", name="pnt_fact")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas le droit d'accés à cette page !")
     * @return Response
     */
    public function printFact(string $slug, ParamsRepository $params,NFactRepository $oldnumFact, ClientRepository $client, CmdClientRepository $CmdClient, CmdRepository $Cmd, Request $request)
    {
        // dd($slug);
        $NbLettre = new NumberConverter();
        $print = new VeiewPrint();
        $numfact = new NFact();
        $datenow = new DateTime(); 
        $Ndate=$datenow->Format("d/m/Y") ; 
        $mng = $this -> getDoctrine()->getManager();
        $form=$this->createForm(ViewPrintType::class, $print);
        $form->handleRequest($request);
        // Configure Dompdf according to your needs
        $Idcmd = $Cmd ->findOneBy(["CmSlug"=>$slug]);
        $cmdc= $Idcmd ->getCmdClient();
        $clcm=$CmdClient ->findOneBy(["id"=>$cmdc]);
        $datecmd= $Idcmd ->getDateCmd();
        $Name= $clcm ->getClSlug();
        // dd($datecmd,$Name);
        $pdfOptions = new Options();
        $param = $params ->findAll();
        $Allcmd= $Cmd ->findBy(["DateCmd"=>$datecmd,"cmdClient"=>$clcm]);
        $Clients= $client ->findOneBy(["Slug"=>$Name]);
        // dd($Clients);
        $countoldnumFact = count($oldnumFact ->findBy(["Dtfct"=>$datecmd,"Compte"=>$clcm->getClSlug()]));
        $total=0;
        foreach ($Allcmd as $cmd) {
            $qte = $cmd->getQte();
            $pu = $cmd->getPu();
            $montant = $qte * $pu;
            $total += $montant;
        }
        $pdfOptions->set('defaultFont', 'Arial');
        $client = $client ->findOneBy(["id"=>$clcm]);
        // dd($client);
        $Nbtotal=$NbLettre->numberToWord($total);
    if($form->isSubmitted()&& $form->isValid()){
        if($countoldnumFact  < 1 ){
            $numfact->setCompte($clcm)
                    ->setDtfct($datecmd);
            $mng -> persist($numfact);
            $mng -> flush();
        }
        $oldFact = ($oldnumFact ->findOneBy(["Dtfct"=>$datecmd,"Compte"=>$clcm->getClSlug()]))->getId();
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
            
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView("data/print.html.twig",[
            'total'=> $total,
            'Nbtotal'=>$Nbtotal,
            'clients'=>$Clients,
            'cmd' => $Allcmd,
            'clcm' => $clcm,
            'client' => $client,
            'param' => $param,
            'Numfact' => $oldFact,
            'Ndate' => $Ndate,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
            
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("FACTURE POUR ".mb_strtoupper($client->getSlug())." DU ".$datecmd->Format("d-m-Y")." .pdf", [
            "Attachment" => true
        ]);
    }
        return $this->render("new/print.html.twig",[
            'total'=> $total,
            'Nbtotal'=> $Nbtotal,
            'clients'=> $Clients,
            'cmd' => $Allcmd,
            'clcm' => $clcm,
            'client' => $client,
            'param' => $param,
            // 'logparam' => $logparam,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/A propos", name="apropos")
     * @return Response
     */
    public function recapmens(ParamsRepository $params):Response
    {
        $param = $params ->findAll();
        return $this->render("home/Apropos.html.twig",[
            'param' => $param,
        ]);
    
    }

    /**
     * @Route("/Depense{slug}/{slug1}", name="printdepense")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function printdepense(string $slug,string $slug1,DepenseRepository $Depense,CmdRepository $cmd,ParamsRepository $params,Request $rqt): Response
    {
            
            $NbLettre = new NumberConverter(); 
            $datenow = new DateTime(); 
            $Ndate=$datenow->Format("d/m/Y à H:m:s ") ; 
            // dd($Ndate);
            $param = $params ->findAll();
            $qb = $Depense->createQueryBuilder('d');
            $Depense = $qb
                ->andwhere('d.DateDps >= :dateDps')
                ->andWhere('d.DateDps <= :dateFin')
                ->setParameter('dateDps', $slug)
                ->setParameter('dateFin', $slug1)
                ->getQuery()
                ->getResult();
            $qc = $cmd->createQueryBuilder('c');
            $cmd = $qc
                ->andwhere('c.DateCmd >= :dateDps')
                ->andWhere('c.DateCmd <= :dateFin')
                ->setParameter('dateDps', $slug)
                ->setParameter('dateFin', $slug1)
                ->getQuery()
                ->getResult();
            $detail = ['Depense' => $Depense, 'cmd' => $cmd];
            $montantdepense = 0; // Initialize the variable outside the loop
            $montantCmd = 0; // Initialize the variable outside the loop
            $depenseDetail = [];
            $cmdDetail = [];
            foreach ($Depense as $depense) {
                $qte = $depense->getQte();
                $prixUnitaire = $depense->getPrixUnitaire();
                $montantdepense += $qte * $prixUnitaire;
                $depenseDetail[] = [
                    'qte' => $qte,
                    'prixUnitaire' => $prixUnitaire,
                    // Add other properties as needed
                ];
            }
            foreach ($cmd as $commande) {
                $qte = $commande->getQte();
                $prixUnitaire = $commande->getPu();
                $montantCmd += $qte * $prixUnitaire;
                $cmdDetail[] = [
                    'qte' => $qte,
                    'prixUnitaire' => $prixUnitaire,
                    // Add other properties as needed
                ];
            }
            $caisse=$montantCmd-$montantdepense;
            $NbtotalDepense=$NbLettre->numberToWord($montantdepense);
            $NbtotalCmd=$NbLettre->numberToWord($montantCmd);
            $NbtotalCaisse=$NbLettre->numberToWord($caisse);
            $pdfOptions = new Options();
            $dompdf = new Dompdf($pdfOptions);
            $html = $this->renderView('data/depense.html.twig', [
                // return $this->render('data/depense.html.twig', [
                'detail'=>['Depense' => $depenseDetail, 'cmd' => $cmdDetail],
                "montantdepense" => $montantdepense,
                "montantCmd" => $montantCmd,
                "caisse" => $caisse,
                "Depense" => $Depense,
                "NbtotalCmd" => $NbtotalCmd,
                "NbtotalDepense" => $NbtotalDepense,
                "NbtotalCaisse" => $NbtotalCaisse,
                "cmd" => $cmd,
                "slug" => $slug,
                "slug1" => $slug1,
                "param" => $param,
                "Ndate" => $Ndate,
            ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("RAPPORT D'ACTIVITE DE STATION RADIO AVEC DU " . $slug . " JUSQU'AU " . $slug1. ".pdf", [
            // $dompdf->stream("RAPPORT D'ACTIVITE DE STATION RADIO AVEC DU " . $slug->Format("d-m-Y") . " JUSQU'AU " . $slug1->Format("d-m-Y") . ".pdf", [
            "Attachment" => true
        ]);
    }
}
