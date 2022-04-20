<?php

namespace App\Controller;

use App\Entity\Cmd;
use App\Form\CmdType;
use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\CmdRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Accueil extends AbstractController{
    /**
     * Undocumented function
     *@Route("/", name="home")
     * @return response
     */
    public function index(){
        return $this->render("home.html.twig");
    }
    /**
     * @Route("/Nouveau", name="Nouveau")
     * @Route("/Client")
     * @Route("/Nouveau_client")
     */
    public function new_client(Request $request){
        $client = new Client() ;
        $form = $this -> createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $manager = $this -> getDoctrine()->getManager();
            $manager -> persist($client);
            $manager -> flush();
            
            return $this->redirectToRoute('Commande');
        }
        return $this->render("Adcm.html.twig",[
            'form'=> $form->createView()
        ]);
    }
        /**
     * @Route("/Nouveau_commande", name="Commande")
     * @Route("/Commande")
     * @Route("/Ncommande")
     */
    public function new_cmd(Request $rqt){
        $cmd = new Cmd() ;
        $form = $this -> createForm(CmdType::class,$cmd);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            // dd($form->getData());
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($cmd);
            $mng -> flush();
            
            return $this->redirectToRoute('Commande');
        }
            return $this->render("Adcm.html.twig",[
                'form'=> $form->createView()
            ]);
    }
    		
    // Pour afficher la liste de commande du client
    /**
     * @Route("/Liste_Commande", name="Liste")
     * @Route("/Listecommande")
     * @Route("/listecommande")
     */
    public function view_cmd(CmdRepository $vend): Response
    {
        // $total = 0;
        // foreach ($somme as $vend)
        // {
        //     $sommeadd=$vend['quantite']->getPrice()*$vend['prixunitaire'];
        //     $somme +=$sommeadd;   
        // }
        $list =$vend ->findAll();
        return $this->render('view.html.twig', [
            'cmd' => $list
            // ,'total'=> $somme
        ]);
    }
    /**
     * Undocumented function
     *@Route("/Suppression/Cmd/{id}", name="del_cmd")
     * @return Response
     */
    public function suppression_cmd($id,SessionInterface $session,CmdRepository $vend)
    {
        $cmd=$session->get('Cmd',[]);
        return $this->redirectToRoute('Liste');
    }
    /**
     * Undocumented function
     *@Route("/Edit/Cmd/{designation}", name="edit_cmd")
     * @return Response
     */
    public function edit_cmd()
    {
        return $this->redirectToRoute('Liste');
    }
}