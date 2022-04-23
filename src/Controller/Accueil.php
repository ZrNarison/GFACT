<?php

namespace App\Controller;

use App\Controller\client as ControllerClient;
use App\Entity\Cmd;
use App\Form\CmdType;
use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\CmdRepository;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ObjectManager;
use Automattic\Jetpack\Connection\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Accueil extends AbstractController{
    
    /**
     * @Route("/",name="login_account")
     * @return Response
     */
    public function login()
    {
        return $this->render('login.html.twig');
    }
    
    /**
     * Undocumented function
     *@Route("/Home", name="home")
     *@Route("/Accueil")
     *@Route("/Homepage")
     *@Route("/home")
     *@Route("/homepage")
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
    public function new_cmd(Request $rqt)
    {
        $cmd = new Cmd();
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
     *@Route("/Suppression/{id}", name="del_cmd")
     * @return Response
     */
    public function del_cmd(CmdRepository $cmd,ObjectManager $manager)
    {
        // $manager = $this -> getDoctrine()->getManager();
        $manager->remove($cmd);
        $manager->flush();
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
    /**
     * @Route("/Deconnexion",name="logout_accout")
     * @Route("/Quit")
     * @return Response
     */
    public function logout_account()
    {
       return $this->redirectToRoute('login_account'); 
    }

}