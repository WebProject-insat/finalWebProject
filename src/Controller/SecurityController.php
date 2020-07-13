<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration",name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder , Filesystem $filesystem)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login",name="security_login");
     */
    public function login(){
        /* Forward to a function in which we define the specefic redirected route depending on the previous paage */
        return $this->render('security/login.html.twig');

    }

    /**
     * @Route("/logout",name="security_logout")
     */
    public function logout(){

    }

    /**
     * @Route("/account/profile",name="account_profile")
     * @return Response
     */
    public function profile(Request $request , ObjectManager $manager , UserPasswordEncoderInterface $encoder ){
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class , $user );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "your Profile is successfuly updated "
            );
            return $this->redirectToRoute('user_show' , ['slug' => $user->getSlug()]);
        }
        return $this->render('security/profile.html.twig',[
            'form'=> $form->createView()
        ]);
    }


}
