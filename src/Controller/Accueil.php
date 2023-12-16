<?php

namespace App\Controller;

use DateTime;
use Dompdf\Dompdf;
use App\Entity\Cmd;
use Dompdf\Options;
use App\Entity\Role;
use App\Entity\User;
use App\Form\CmdType;
use App\Entity\Client;
use App\Entity\Params;
use App\Form\LogoType;
use App\Form\UserType;
use App\Entity\Project;
use App\Form\ClassType;
use App\Form\ClientType;
use App\Form\ParamsType;
use App\Entity\CmdClient;
use App\Form\EditCmdType;
use App\Form\ProjectType;
use App\Entity\VeiewPrint;
use App\Form\EditUserType;
use Cocur\Slugify\Slugify;
use App\Form\PhotoUserType;
use App\Form\ViewPrintType;
use App\Form\EditClientType;
use App\Form\ParamsEditType;
use App\Form\EditcClientType;
use App\Entity\PropertySearch;
use App\Entity\UpdatePassword;
use App\Form\EditPasswordType;
use App\Form\PropertySearchType;
use App\Service\NumberConverter;
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
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Accueil extends AbstractController{
    
    /**
     * Undocumented function
     * @Route("/", name="home")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return response
     */
    public function index(){
        return $this->render("home.html.twig");
    }
    
    /**
     * @Route("/newrole", name="nclass")
     * @Route("/newclass")
     * @Security("is_granted('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
     * @Route("/Nouveau", name="nclient")
     * @Route("/Client")
     * @Route("/client")
     * @Security("is_granted('ROLE_USER')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function new_client(Request $request){
        $client = new Client() ;
        $dateclient = new DateTime ();
        $clientCmd = new CmdClient();
        $form = $this -> createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $slugify = new Slugify();
                $nd = $form->get('NCmd')->getData();
                $cc = $form->get('CClient')->getData();
                $ds = $form->get('Dos')->getData();
                $df = $form->get('Dif')->getData();
                $b = $form->get('NomCl')->getData();
                $a = $form->get('Adress')->getData();
                $newslug = $slugify ->slugify($form->get('NomCl')->getData()).'-'.$slugify ->slugify($form->get('Adress')->getData());
                $manager = $this-> getDoctrine()->getManager();
                $client->setSlug($newslug);
                $manager -> persist($client);
                $clientCmd  ->setNCmd($nd)
                            ->setCClient($cc)
                            ->setDos($ds)
                            ->setDif($df)
                            // ->setDateCmdClient($dateclient)                           
                            ->setClSlug($newslug)                           
                            ;
                $manager->persist($clientCmd);
                $client->addCmd($clientCmd);
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
     * @Route("/ad/commande", name="Commande")
     * @Route("/Commande")
     * @Route("/ad/index")
     * @Route("/ad/Ncommande")
     * @Security("is_granted('ROLE_USER')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function new_cmd(Request $rqt )
    {
        $client= new Client();
        $cmd = new Cmd();
        $date = new DateTime();
        $form = $this -> createForm(CmdType::class, $cmd);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $slugify = new Slugify();
            $clcmmc= $form->get('cmdClient')->getData();
            $cmdslug=$clcmmc."-".$date->Format("d-m-Y");
            $Annees=$date->Format("Y");
            $Mois=$date->Format("m-Y");
            $mng = $this -> getDoctrine()->getManager();
            $cmd->setDateCmd($date)
                ->setAnnees($Annees)
                ->setCmSlug($cmdslug)
                ->setMois($Mois);
            $mng -> persist($cmd);
            $clcmmc->addCmd($cmd);
            $mng -> flush();           
            return $this->redirectToRoute('Commande');
        }
        return $this->render("new/Adcm.html.twig",[
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/ad/new_dev", name="newportofolio")
     * @Route("/ad/newdev")
     * @Route("/ad/new_projet")
     * @Route("/ad/newprojet")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return response
     */
    public function ndev(Request $rqt,UserPasswordEncoderInterface $encoder){
        $dev = new Project();
        $form=$this->createForm(ProjectType::class, $dev);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $slugify = new Slugify();
            $fichier = $form->get('fichiers')->getData();
            $slugf=$slugify ->slugify($form->get('Title')->getData().'-'.$form->get('Version')->getData());
            $name = $form->get('Title')->getData();
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
                return $this->redirectToRoute("newportofolio");
        }
        return $this->render("new/Adfolio.html.twig",[
            "form"=> $form->createView()
        ]);
     }

    /**
     * Pour afficher la liste du client
     * @Route("/view/", name="Liste_client")
     * @Route("/view/Listeclient")
     * @Route("/view/listeclient")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function view_clt(CmdClientRepository $Client, SessionInterface $session, $page=1): Response
    {
        $limite = 5;
        $client =$Client ->findBy([],[],$limite,0);
        return $this->render('vue/viewL.html.twig', [
            'client' => $client            
        ]);
    }
    	
    /**
     * Pour afficher la liste de commande du client
     * @Route("/view/Liste_Commande", name="Liste_cmd")
     * @Route("/view/Listecommande")
     * @Route("/view/listecommande")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function view_cmd(cmdClientRepository $cmdclient,cmdRepository $cmd, SessionInterface $session,Request $request,$page=1): Response
    {
        $limit = 10;
        $start = $page * $limit - $limit;
        $search = new PropertySearch();
        $form = $this->Createform(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $Cmd =$cmd ->findBy([],[],$limit,0);
        $cmdclient =$cmdclient ->findAll();
        if($form->isSubmitted()&& $form->isValid()){
            $nom=$form->get("NomClient")->getData();
            $datecmd=$form->get("DateCmd")->getData();
            $date=$datecmd->Format("d-m-Y");
            $moisdate=$form->get("DateCmd")->getData()->Format("m-Y");
            $anneesdate=$form->get("DateCmd")->getData()->Format("Y");
            $slug=$nom."-".$date;
            $Cmd = $cmd->findBy(["DateCmd"=>$datecmd,"cmdClient"=>$nom]);
            $OneCmd = $cmd->findOneBy(["DateCmd"=>$datecmd,"cmdClient"=>$nom]);
            $countCmd = count($cmd->findBy(["DateCmd"=>$datecmd,"cmdClient"=>$nom]));
            if($countCmd != 0){
                $CmdClient=$OneCmd->getCmdClient();
                return $this->render("vue/viewC.html.twig",[
                    "cmd"=> $Cmd,
                    "OneCmd"=> $OneCmd,
                    "moisdate"=> $moisdate,
                    "anneesdate"=> $anneesdate,
                    "nom"=> $nom,
                    "datecmd"=> $datecmd,
                    'form' => $form->createView()
                ]);
            };
            return $this->render('vue/viewC.html.twig', [
                'cmd' => $Cmd,
                "nom"=> '',
                "datecmd"=> '',
                "CmdClient"=> '',
                'form' => $form->createView()
            ]);
        }
        return $this->render('vue/viewC.html.twig', [
            'cmd' => $Cmd,
            "nom"=> '',
            "datecmd"=> '',
            "CmdClient"=> '',
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * Pour afficher la liste de commande du client
    //  * @Route("/view/Liste_Commande", name="Liste_cmd")
    //  * @Route("/view/Listecommande")
    //  * @Route("/view/listecommande")
    //  * @Security("is_granted('ROLE_USER')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
    //  */
    // public function view_cmd(CmdRepository $cmd, SessionInterface $session,Request $request): Response
    // {
    //     $search = new PropertySearch();
    //     $slug = new Slugify();
    //     $form = $this->Createform(PropertySearchType::class,$search);
    //     $form->handleRequest($request);
    //     $Cmd =$cmd ->findAll();
    //     $date = new DateTime();
    //     $moisdate = $date ->Format("m-Y");
    //     $anneesdate = $date ->Format("m-Y");
    //     if($form->isSubmitted()&& $form->isValid()){
    //         $nom=$form->get("NomClient")->getData();
    //         $date=$form->get("DateCmd")->getData()->Format("d-m-Y");
    //         $moisdate=$form->get("DateCmd")->getData()->Format("m-Y");
    //         $anneesdate=$form->get("DateCmd")->getData()->Format("Y");
    //         $slug=$nom."-".$date;
    //         $Cmd = $cmd ->findBy(["cmdsulg"=>$slug]);
    //         return $this->render("vue/viewC.html.twig",[
    //             "Cmd"=> $Cmd,
    //             "moisdate"=> $moisdate,
    //             "anneesdate"=> $anneesdate,
    //             "slug"=> $slug,
    //             'form' => $form->createView()
    //         ]);
    //     }
    //     return $this->render('vue/viewC.html.twig', [
    //         'Cmd' => $Cmd,
    //         "moisdate"=> $moisdate,
    //         "anneesdate"=> $anneesdate,
    //         "slug"=> '',
    //         'form' => $form->createView()
    //     ]);
    // }

    /**
     * Pour afficher la liste d'Utilisateur
     * @Route("/view/Liste_Utilisateur", name="Liste_user")
     * @Route("/view/Listeuser")
     * @Route("/view/listeUser")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
     * @Route("/view/portfolio", name="portfolio")
     * @Route("/view/porto-folio")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
     * @Route("/voire/liste_project", name="zfolio")
     * @Route("/view/devporto-folio")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
    /**
     * Suppression compte d'utilisateur
     * Undocumented function
     * @Route("/Suppression/{id}", name="del_user")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return Response
     */
    public function del_user(User $user):Response
    {
        $mgr = $this -> getDoctrine()->getManager();
        $mgr->remove($user);
        $mgr->flush();
        return $this->redirectToRoute('Liste_user');
    }
    /**
     * @Route("/logos/{slug}", name="paralogos")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function modlogod(string $slug,ParamsRepository $Param, Request $rqt)
    {
        $param=$Param->findOneBy(['PSlug'=>$slug]);
        $form=$this->createForm(LogoType::class, $param);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $fichier = $form->get('Logos')->getData();
            $directory=$this->getParameter('params_directory');
            $filename=md5(uniqid()).'.'. $fichier->guessExtension();
            $param->setLogos($filename)
            ;
            $mng -> persist($param);
            $mng -> persist($param);            
            $fichier->move(
                $directory,
                $filename
            );             
            $mng -> flush();
            return $this->redirectToRoute("set");
        }
        return $this->render("new/editlogo.html.twig",[
            "form"=> $form->createView(),
            'param' => $param
        ]);
    }
    /**
     * @Route("/EditMyPhoto", name="edit_photo")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     */
    public function modphoto(UserRepository $user, Request $rqt)
    {
        $user = $this->getUser();
        $form=$this->createForm(PhotoUserType::class, $user);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $fichier = $form->get('picture')->getData();
            $directory=$this->getParameter('uploads_directory');
            $filename=md5(uniqid()).'.'. $fichier->guessExtension();
            $user->setPicture($filename)
            ;
            $mng -> persist($user);
            $mng -> persist($user);            
            $fichier->move(
                $directory,
                $filename
            );             
            $mng -> flush();
            return $this->redirectToRoute("home");
        }
        return $this->render("new/editphoto.html.twig",[
            "form"=> $form->createView(),
            'user' => $user
        ]);
    }
    /**
     * Suppression du commande
     * @Route("/Delete/{slug}", name="del_cmd")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return Response
     */
    public function del_cmd(string $slug,CmdRepository $Cmd):Response
    {
        $cmd=$Cmd->findOneBy(['id'=>$slug]);
        $mgr = $this -> getDoctrine()->getManager();
        $mgr->remove($cmd);
        $mgr->flush();
        return $this->redirectToRoute('Liste_cmd');
    }

    /**
     * //Modification du client//
     * @Route("/{slug}/Editer", name="editclient")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return Response
     */
    public function client_edit(string $slug,ClientRepository $repository,CmdClientRepository $cmsClient, Request $rqt):Response
    {
        
        $client=$repository->findOneBy(['Slug'=>$slug]);
        $form=$this->createForm(EditClientType::class, $client);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $slugify = new Slugify();
            $mng = $this -> getDoctrine()->getManager();
            $newslug = $slugify ->slugify($form->get('NomCl')->getData()).'-'.$slugify ->slugify($form->get('Adress')->getData());
            $client->setSlug($newslug);
            $mng -> persist($client);            
            $mng -> flush();
            return $this->redirectToRoute("Liste_client");
        }
        return $this->render("new/editcl.html.twig",[
            "form"=> $form->createView(),
            'client' => $client
        ]);
    }

    /**
     * //Modification du clientcommande//
     * @Route("/Modifier/{slug}/", name="editcclient")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return Response
     */
    public function clientedit(string $slug,CmdClientRepository $repository,CmdClientRepository $cmsClient, Request $rqt):Response
    {
        
        $client=$repository->findOneBy(['ClSlug'=>$slug]);
        $form=$this->createForm(EditcClientType::class, $client);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $slugify = new Slugify();
            $mng = $this-> getDoctrine()->getManager();
            $mng -> persist ($client);
            $mng-> flush();
            return $this->redirectToRoute("Liste_client");
        }
        return $this->render("new/editcl.html.twig",[
            "form"=> $form->createView(),
            'client' => $client
        ]);
    }
    
  /**
     * Suppression de client
     * @Route("/{slug}/del", name="delclient")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return Response
     */
    public function del_client(string $slug,ClientRepository $clientrepository,CmdClientRepository $cmdClient)
    {
        $client=$clientrepository->findBy(['Slug'=>$slug]);
        $cmdclient=$cmdClient->findBy(['ClSlug'=>$slug]);
        $mgr = $this -> getDoctrine()->getManager();
        $mgr->remove($cmdclient);
        $mgr->remove($client);
        $mgr->flush();
        return $this->redirectToRoute('Liste_client');
    }
    
    
    /**
     * //Modification de commande//
     * @Route("/Editer-{CmSlug}", name="editcommande")
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return Response
     */
    public function edit_cmd(string $CmSlug,CmdRepository $repository ,Request $rqt)
    {
        $cmd=$repository->findOneBy(['CmSlug'=>$CmSlug]);
        $form = $this -> createForm(EditCmdType::class, $cmd);
        $form -> handleRequest($rqt);
        if($form->isSubmitted()&&$form->isValid()){
            $slugify = new Slugify();
            // dd($form->get('Design')->getData());
            $slug = $slugify->slugify($form->get('Design')->getData() . '-' .$form->get('Qte')->getData() . '-' .$form->get('Pu')->getData() . '-' .$form->get('prd')->getData() . '-' .$form->get('duree')->getData());
            $cmd->setCmSlug($slug);
            $mng = $this-> getDoctrine()->getManager();
            $mng -> persist ($cmd);
            $mng-> flush();
            return $this->redirectToRoute('Liste_cmd');
        }
        return $this->render("new/editcmd.html.twig",[
            "form"=> $form->createView(),
            "cmd"=>$cmd
        ]);
    }
    /**
     * @Route("/Deconnexion",name="logout_accout")
     * @return Response
     */
    public function logout_account()
    {
       return $this->redirectToRoute('login_access'); 
    }

    /**
     * @Route("/login", name="login_access")
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
     * @Route("/Ad/new_compte", name="ncompte")
     * @Route("/Ad/newcompte")
     * @Route("/Ad/ncompte")
     * @Security("is_granted('ROLE_SUPERADMIN')",message="Vous n'avez pas le droit d'accés à cette page !")
     * @return response
     */
    public function ncompte(Request $rqt,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $fichier = $form->get('picture')->getData();
            $newclass = $form->get('class')->getData();
            $name = $form->get('pseudo')->getData();
            $directory=$this->getParameter('uploads_directory');
            $filename=md5(uniqid()).'.'. $fichier->guessExtension();
            $user->setPicture($filename)
            ;
            $hash=$encoder->encodePassword($user,$user->getMdp());
            $user->setMdp($hash);
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($user);
            $user -> addUserRole($newclass);
            $fichier->move(
                $directory,
                $filename
            );            
            $mng -> flush();
            $this->addFlash(
                "success",
                "  Le compte de <strong> {$user->getPseudo()}</strong> a été bien enregistrer"
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
      * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
     * @Route("/Edit/settings/{slug}",name="params")
     * @Security("is_granted('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
     * @return response
     */
    public function setting_edit(string $slug,ParamsRepository $repository, Request $rqt)
    {
        $param=$repository->findOneBy(['PSlug'=>$slug]);
        $form=$this->createForm(ParamsEditType::class, $param);
        $form->handleRequest($rqt);
        if($form->isSubmitted()&& $form->isValid()){
            $mng = $this -> getDoctrine()->getManager();
            $mng -> persist($param);   
            $mng -> flush();
            return $this->redirectToRoute("set");
        }
        return $this->render("new/editparam.html.twig",[
            "form"=> $form->createView(),
            'param' => $param
        ]);
    }

     /**
      * @Route("/Modifier-user", name="edit_user")
      * @Route("/Modifieruser")
      * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
     * @Security("is_granted('ROLE_USER') or('ROLE_ADMIN')",message="Vous n'avez pas l'autorisation d'accés à cette page !")
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
     * 
     * @return Response
     */
    public function myaccount()
    {
        return $this->render("security/myuser.html.twig",[
            "user"=> $this->getUser()
        ]);
    }
          
    /**
     * @Route("/facture/{slug}", name="pnt_fact")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas le droit d'accés à cette page !")
     * @return Response
     */
    public function printFact(string $slug, ParamsRepository $params, ClientRepository $client, CmdClientRepository $CmdClient, CmdRepository $Cmd, Request $request)
    {
        $NbLettre = new NumberConverter();
        $print = new VeiewPrint();
        $form=$this->createForm(ViewPrintType::class, $print);
        $form->handleRequest($request);
        // Configure Dompdf according to your needs
        $Idcmd = $Cmd ->findOneBy(["CmSlug"=>$slug]);
        $cmdc= $Idcmd ->getCmdClient();
        $clcm=$CmdClient ->findOneBy(["id"=>$cmdc]);
        $datecmd= $Idcmd ->getDateCmd();
        $pdfOptions = new Options();
        $param = $params ->findAll();
        $Allcmd= $Cmd ->findBy(["DateCmd"=>$datecmd,"cmdClient"=>$clcm]);
        $total=0;
        foreach ($Allcmd as $cmd) {
            $qte = $cmd->getQte();
            $pu = $cmd->getPu();
            $montant = $qte * $pu;
            $total += $montant;
        }
        $pdfOptions->set('defaultFont', 'Arial');
        $client = $client ->findOneBy(["id"=>$clcm]);
        $Nbtotal=$NbLettre->numberToWord($total);
    if($form->isSubmitted()&& $form->isValid()){
        // dd($NbLettre);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
            
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView("data/print.html.twig",[
            'total'=> $total,
            'Nbtotal'=>$Nbtotal,
            'cmd' => $Allcmd,
            'clcm' => $clcm,
            'client' => $client,
            'param' => $param,
            // 'logparam' => $logparam,
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
            'cmd' => $Allcmd,
            'clcm' => $clcm,
            'client' => $client,
            'param' => $param,
            // 'logparam' => $logparam,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/Recap/{slug}", name="recapmens")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas le droit d'accés à cette page !")
     * @return Response
     */
    public function recapmens(string $slug,ParamsRepository $params,ClientRepository $Client,CmdRepository $Cmd,Request $rqt)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $param = $params ->findAll();
        $Client = $Client ->findAll();
        $pdfOptions->set('defaultFont', 'Arial');
        $cmd = $Cmd ->findBy(["Mois"=>$slug]);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
            $html = $this->renderView("data/mensuelle.html.twig",[
            'cmd' => $cmd,
            'param' => $param
            ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        // $dompdf->stream("FACTURE DE ". mb_strtoupper($nom->getNomCl())." ".($nom->getNomCl()).".pdf", [
            $dompdf->stream("RECAPITULATION MENSUELLE ".$slug.".pdf", [
                "Attachment" => true,
            ]);
    }

    /**
     * @Route("/{slug}/recap", name="recapannu")
     * @Security("is_granted('ROLE_USER') or ('ROLE_ADMIN') or ('ROLE_SUPERADMIN')",message="Vous n'avez pas le droit d'accés à cette page !")
     * @return Response
     */
    public function recapannu(string $slug,ParamsRepository $params,ClientRepository $Client,CmdRepository $Cmd,Request $rqt)
    {
    // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $param = $params ->findAll();
        $Client = $Client ->findAll();
        $pdfOptions->set('defaultFont', 'Arial');
        $cmd = $Cmd ->findBy(["Annees"=>$slug]);
        // dd($param);
    // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
    // Retrieve the HTML generated in our twig file
        $html = $this->renderView("data/annuelle.html.twig",[
            'cmd' => $cmd,
            'param' => $param,
        ]);
    
    // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
        $dompdf->render();

    // Output the generated PDF to Browser (force download)
        // $dompdf->stream("FACTURE DE ". mb_strtoupper($nom->getNomCl())." ".($nom->getNomCl()).".pdf", [
        $dompdf->stream("RECAPITULATION ANNUELLE ".$slug.".pdf", [
            "Attachment" => true
        ]);
    }


    /**
     * Impression d'extrait de Curriculium Vitae
     * @Route("/moncv", name="me")
     * @Route("/MonCV")
     * @Route("/Mon-CV")
     * 
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
     * @return Response
     */
    public function dev(string $mo,ProjectRepository $Project ):Response
    {
        $project=$Project->findOneBy(['Slug'=>$mo]);
        return $this->render("vue/onedev.html.twig",[
            'dev'=>$project
        ]);
    }
    
}