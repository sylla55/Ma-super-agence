<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;

class SecurityController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    private $encoder;

    public function __construct (ObjectManager $em,UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
    * @Route("/login",name="login")
    */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $errors = $authenticationUtils->getLastAuthenticationError();
        return $this->render("security/index.html.twig",[
            'lastUsername'=>$lastUsername,
            'errors' =>$errors
        ]);
    }

    /**
    * @Route("/register",name="register")
    */
    public function register(Request $request)
    {
        $user =new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $user->getPassword();
            $user->setPassword($this->encoder->encodePassword($user,$password));
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('login');
        }   

        return $this->render("security/register.html.twig",[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
    }
}