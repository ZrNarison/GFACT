<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Cmd;
use Dompdf\Options;
use App\Entity\Role;
use App\Entity\User;
use App\Form\CmdType;
use App\Entity\Client;
use App\Entity\Params;
use App\Form\UserType;
use App\Entity\Project;
use App\Form\ClassType;
use App\Form\ClientType;
use App\Form\ParamsType;
use App\Entity\CmdClient;
use App\Form\EditCmdType;
use App\Form\ProjectType;
use App\Form\EditUserType;
use Cocur\Slugify\Slugify;
use App\Form\EditClientType;
use App\Form\ParamsEditType;
use App\Entity\UpdatePassword;
use App\Form\EditPasswordType;
use App\Repository\CmdRepository;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\ParamsRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Form\FormError;
use App\Repository\CmdClientRepository;
use Doctrine\Persistence\ObjectManager;
use Automattic\Jetpack\Connection\Manager;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\client as ControllerClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Accueil extends AbstractController{
    
    /**
     * Undocumented function
     * @Route("/index", name="home")
     * @Route("/")
     * @Route("/home")
     * @Route("/Home")
     * @Route("/homepage")
     * @IsGranted("ROLE_USER")
     * @return response
     */
    public function index(){
        return $this->render("home.html.twig");
    }

    /**
     * @Route("/",name="login_account")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        return $this->render("security/login.html.twig",[
            'err'=>$error !==null
        ]);
    }
    
    /**
     * @Route("/newrole", name="nclass")
     * @Route("/newclass")
     * @IsGranted()
     * @IsGranted("ROLE_USER")
     * @return Response
     */
     public function new_class(Request $rqt)
     {
        $nclass= new Role();
        $form = $this -> createForm(ClassType::class,$nclass);
        $form ->handleRequest($rqt);
        if($form->isSubmitted()){
            $mgr = $this -> getDoctrine()->getManager();
            $mgr -> persist($nclass);
            $mgr -> flush(); 
            $this->addFlash(
                "success",
                "La class N° <strong> {$nclass->getId()}</strong> dont son nom est <strong>  {$nclass->getTitle()} </strong> à été bien enregistré !"
            );
            return $this->redirectToRoute('nclass');           
        }
        return $this->render("new/Adclass.html.twig",[
            'form'=> $form->createView()
        ]);
     }
    
    /**
     * @Route("/Nouveau", name="Nouveau")
     * @Route("/Client")
     * @Route("/client")
     * @Route("/Nouveau_client")
     * @IsGranted("ROLE_USER")
     */
    public function new_client(Request $request){
        $client = new Client() ;
        $clientCmd = new CmdClient();
        $slugify = new Slugify();
        $form = $this -> createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted()){
                // $ClId = $this->getClient();
                $nd = $form->get('NCmd')->getData();
                $cc = $form->get('CClient')->getData();
                $ds = $form->get('Dos')->getData();
                $df = $form->get('Dif')->getData();
                $slg = $form->get('NomCl')->getData();
                // $Id = $ClId->getId();
                $Islg = $slugify ->slugify($slg);
            $manager = $this-> getDoctrine()->getManager();
                $clientCmd  ->setNCmd($nd)
                            ->setCClient($cc)
                            ->setDos($ds)
                            ->setDif($df)
                            ->setDif($df)                           
                            ->setClSlug($Islg)                           
                            ;
                $manager->persist($clientCmd);
                $client->addCCmd($clientCmd);
            $manager -> persist($client);
            $manager -> flush(); 
            $this->addFlash(
                "success",
                "Le client N° <strong> {$client->getId()}</strong> dont son nom est <strong>  {$client->getnomcl()} </strong> à été bien enregistré !"
            );
            return $this->redirectToRoute('Commande');
           
        }
        return $this->render("new/Adcl.html.twig",[
            'form'=> $form->createView()
        ]);
    }
    /**
     * @Route("/Nouveau_commande", name="Commande")
     * @Route("/Commande")
     * @Route("/Ncommande")
     * @IsGranted("ROLE_USER")
     */
    public function new_cmd(Request $rqt )
    {
        $client= new Client();
        $cclient= new CmdClient();
        $cmd = new Cmd();
        $slugify = new Slugify();
        // $tdat = date("Y-m-d");
        $form = $this -> createForm(CmdType::class,$cmd);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $dsg = $form->get('Design')->getData();
            $Id = $form->get('CmdClient')->getData();
            $dgn = $slugify ->slugify($dsg);
            $cmd->setCmSlug($dgn)
                // ->setDtCmd($tdat);
                ;
            // dump($Id);
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($cmd);
            $cclient->addCmdClt($cmd);
            $mng -> flush();
            return $this->redirectToRoute('Commande');
        }
        return $this->render("new/Adcm.html.twig",[
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/new_dev", name="new-porto-folio")
     * @Route("/newdev")
     * @Route("/new_projet")
     * @Route("/newprojet")
     * @IsGranted("ROLE_USER")
     * @return response
     */
    public function ndev(Request $rqt,UserPasswordEncoderInterface $encoder){
        $dev = new Project();
        $slug = new Slugify();
        $form=$this->createForm(ProjectType::class, $dev);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $fichier = $form->get('fichiers')->getData();
            $name = $form->get('Title')->getData();
            $slugf = $slug ->slugify($name);
            $directory=$this->getParameter('dev_directory');
            $filename=md5(uniqid()).'.'. $fichier->guessExtension();
            $dev->setFichiers($filename)
                ->setSlug($slugf)
            ;
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($dev);
            $fichier->move(
                $directory,
                $filename
            );              
            $mng -> flush();
            $this->addFlash(
                "success",
                " {$dev->getTitle()}</strong> Votre projet a été bien enregistrer"
            );
                return $this->redirectToRoute("new-porto-folio");
        }
        return $this->render("new/Adfolio.html.twig",[
            "form"=> $form->createView()
        ]);
     }


    // Pour afficher la liste du client
    /**
     * @Route("/Liste_Client", name="Liste_client")
     * @Route("/Listeclient")
     * @Route("/listeclient")
     * @IsGranted("ROLE_USER")
     */
    public function view_clt(ClientRepository $clt,CmdClientRepository $Cclt, SessionInterface $session, $page=1): Response
    {
        $limites=10;
        $list =$clt ->findAll([],[],$limites);
        $Clist =$Cclt ->findAll();
        return $this->render('vue/viewL.html.twig', [
            'client' => $list,
            'clientcmd' => $Clist
        ]);
    }
    		
    // Pour afficher la liste de commande du client
    /**
     * @Route("/Liste_Commande", name="Liste_cmd")
     * @Route("/Listecommande")
     * @Route("/listecommande")
     * @IsGranted("ROLE_USER")
     */
    public function view_cmd(ClientRepository $clt,CmdRepository $vend, SessionInterface $session): Response
    {
        $list =$vend ->findAll();
        $client =$clt ->findAll();
        return $this->render('vue/viewC.html.twig', [
            'cmd' => $list,
            'cl' => $client,
            // ,'total'=> $somme
        ]);
    }

    // Pour afficher la liste d'Utilisateur
    /**
     * @Route("/Liste_Utilisateur", name="Liste_user")
     * @Route("/Listeuser")
     * @Route("/listeUser")
     * @IsGranted("ROLE_USER")
     */
    public function view_user(UserRepository $user, SessionInterface $session): Response
    {
        $list =$user ->findAll();
        return $this->render('vue/viewU.html.twig', [
            'user' => $list
            // ,'total'=> $somme
        ]);
    }

    
    /**
     * @Route("/portfolio", name="portfolio")
     * @Route("/porto-folio")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function pfolio(ProjectRepository $project)
    {
        $tdat = date("Y");
        $dev =$project ->findAll();
        return $this->render("data/portfolio.html.twig",[
            'dat'=>$tdat,
            'dev'=>$dev,
        ]);
        
    }
    /**
     * @Route("/devportfolio", name="pfolio")
     * @Route("/devporto-folio")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function portfolio(ProjectRepository $project):Response
    {
        $tdat = date("Y");
        $dev =$project ->findAll();
        return $this->render("vue/portfolio.html.twig",[
            'dat'=>$tdat,
            'dev'=>$dev,
        ]);
        
    }

    //Modification du client
    /**
     * @Route("/Edit/{NomCl}", name="edit_client")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function client_edit(Client $NomCl, Request $rqt):Response
    {
        $form=$this->createForm(EditClientType::class, $NomCl);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($NomCl);            
            $mng -> flush();
            return $this->redirectToRoute("view");
        }
        return $this->render("new/editcl.html.twig",[
            "form"=> $form->createView(),
            'ed' => $NomCl
        ]);
    }
    //Modification du commande
    /**
     * @Route("/Edit/{slug}", name="edit_commande")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function cmd_edit(Cmd $cmd, Request $rqt):Response
    {
        $form=$this->createForm(EditCmdType::class, $cmd);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($cmd);            
            $mng -> flush();
            return $this->redirectToRoute("Liste_cmd");
        }
        return $this->render("new/editcmd.html.twig",[
            "form"=> $form->createView(),
            'ed' => $cmd
        ]);
    }

    //Suppression d'un client
    /**
     * Undocumented function
     * @Route("/Suppression/{id}", name="del_client")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function del_client(Client $client)
    {
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($client);
        $manager->flush();
        return $this->redirectToRoute('Liste_client');
    }
    /**
     * Undocumented function
     * @Route("/Suppression/{id}", name="del_cmd")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function del_cmd(CmdRepository $cmd)
    {
        $manager = $this -> getDoctrine()->getManager();
        $manager->remove($cmd);
        $manager->flush();
        return $this->redirectToRoute('Liste');
    }
    /**
     * Undocumented function
     *@Route("/Edit/Cmd/{designation}", name="edit_cmd")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function edit_cmd()
    {
        return $this->redirectToRoute('Liste');
    }
    /**
     * @Route("/Deconnexion",name="logout_accout")
     * @Route("/Quit")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function logout_account()
    {
       return $this->redirectToRoute('login_account'); 
    }

    /**
     * @Route("/login", name="login_acces")
     * @return response
     */
    public function acces_login(AuthenticationUtils $verif)
    {
        $err = $verif -> getLastAuthenticationError();
        $username=$verif->getLastUsername();
        return $this->render('security/login.html.twig',[
            'err'=> $err !== null,
            'uti'=>$username
        ]);
    }


    /**
     * @Route("/new_compte", name="ncompte")
     * @Route("/newcompte")
     * @Route("/ncompte")
     * @IsGranted("ROLE_USER")
     * @return response
     */
    public function ncompte(Request $rqt,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $slug = new Slugify();
        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $fichier = $form->get('picture')->getData();
            $name = $form->get('pseudo')->getData();
            $slugf = $slug ->slugify($name);
            $directory=$this->getParameter('uploads_directory');
            $filename=md5(uniqid()).'.'. $fichier->guessExtension();
            $user->setPicture($filename)
            ;
            $hash=$encoder->encodePassword($user,$user->getMdp());
            $user->setMdp($hash);
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($user);
            $fichier->move(
                $directory,
                $filename
            );            
            $mng -> flush();
            $this->addFlash(
                "success",
                " {$user->getpseudo()}</strong> Votre compte a été bien enregistrer"
            );
                    return $this->redirectToRoute("ncompte");
        }
        return $this->render("security/newuser.html.twig",[
            "form"=> $form->createView()
        ]);
     }
     /**
      * //Visualisation de paramettre
      * @ROute ("/setting", name="set")
      * @Route("/settings")
     * @IsGranted("ROLE_USER")
      */
    public function setting(ParamsRepository $prmt )
    {
        $list =$prmt ->findAll();
        return $this->render('vue/viewP.html.twig', [
            'parm' => $list
        ]);
    }

    /**
     * //Modification de paramettre
     * @Route("/Edit/settings/{parm}",name="params")
     * @IsGranted("ROLE_USER")
     * @return response
     */
    public function setting_edit(Params $parm, Request $rqt)
    {
        $form=$this->createForm(ParamsEditType::class, $parm);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($parm);            
            $mng -> flush();
            return $this->redirectToRoute("set");
        }
        return $this->render("new/editparam.html.twig",[
            "form"=> $form->createView(),
            'ed' => $parm
        ]);
    }

     /**
      * @Route ("/Edit-profil", name="edit_user")
      * @Route("/Edituser")
      * @Route("/edituser")
      * @Route("/Modifier-user")
      * @Route("/Modifieruser")
     * @IsGranted("ROLE_USER")
      * @return response
      */

      public function edit_user(Request $rqt)
      {
          $user = $this->getUser();
          $form=$this->createForm(EditUserType::class, $user);
          $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($user);        
            $mng -> flush();
                    return $this->redirectToRoute("home");
        }
        return $this->render("security/edituser.html.twig",[
            'form'=> $form->createView()
        ]);
      }

    /**
     * @Route("/update-password", name="editpass")
     * @Route("/updatepass")
     * @IsGranted("ROLE_USER")
     * @return response
     */
    public function Pass_Update(Request $rqt,UserPasswordEncoderInterface $encoder )
    {
        $oldpass = $this->getUser();
        $newpass = new UpdatePassword();
        $form = $this->createForm(EditPasswordType::class, $newpass);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            //Verification de l'ancien mot de passe
            if(!password_verify($newpass->getOldPassword(),$oldpass->getMdp())){
                $form->get('OldPassword')->addError(new FormError("L'ancien mot de passe que vous avez entrer n'est pas votre mot de pass valide !") );
            }else{
                $newp=$newpass->getNewPassword();
                $hash=$encoder->encodePassword($oldpass,$newp);
                $oldpass->setMdp($hash);
                $mng = $this -> getDoctrine()->getManager();
                $mng -> persist($oldpass);
                $mng -> flush();
                $this->addFlash("success","Votre mot de passe a était bien modifier !");
                        return $this->redirectToRoute("home");
            }
        }
        return $this->render("security/editpass.html.twig",[
            'form'=> $form->createView()
        ]);
    }

    /**
     * //Afficher l'utilisateur connecter
     * @Route("/account", name="user_account")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function myaccount()
    {
        return $this->render("security/myuser.html.twig",[
            "user"=> $this->getUser()
        ]);
    }
          
    /**
     * @Route("/vue/{NomCl}", name="pnt_fact")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function print_fact(Client $nom,CmdClientRepository $rq_C,ClientRepository $rq_cmd,Request $rqt)
    {
                
    // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $fcl = $rq_C->findAll();
        $fcmd = $rq_cmd->findAll();
        // dump($nom);die;
        
    // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
    // Retrieve the HTML generated in our twig file
        $html = $this->renderView("data/print.html.twig",[
            'c' => $nom,
            'cl' => $fcl,
            'd' => $fcmd
        ]);
    
    // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
        $dompdf->render();

    // Output the generated PDF to Browser (force download)
        $dompdf->stream("FACTURE DE ". mb_strtoupper($nom->getNomCl())." ".($nom->getNomCl()).".pdf", [
            "Attachment" => true
        ]);
    }


    /**
     * Impression d'extrait de Curriculium Vitae
     * @Route("/moncv", name="me")
     * @Route("/MonCV")
     * @Route("/Mon-CV")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function prin_cv()
    {
        $tdat = date("Y");
        return $this->render("data/folio.html.twig",[
            'dat'=>$tdat
        ]);
    }

    /**
     * @Route("/dev/{mo}",name="vue_dev")
     * ParamConverter("mo",options:["exclude"=>['slug']])
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function dev(Project $mo ):Response
    {
        // $dev=$devslug->findOneById($mo);

        return $this->render("vue/onedev.html.twig",[
            'dev'=>$mo
        ]);
    }
    
}