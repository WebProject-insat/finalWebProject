<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Announcement;
use App\Entity\Image;
use App\Form\AdType;
use App\Form\AnnouncementType;
use Container6dcg3sA\getConsole_ErrorListenerService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnouncementRepository;
use App\Entity\User;

class AnnouncementController extends AbstractController
{
    /**
     * @Route("/announcement/new", name="new_announcement")
     */
    public function index(Request $request , ObjectManager $manager)
    {
        if( !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $session = $request->getSession() ;
            $this->addFlash('error' , 'You need to Log In first !');
            return $this->redirectToRoute('security_login') ;

        }
        $ann = new Announcement() ;

        $form = $this->createForm(AnnouncementType::class , $ann) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted() && $form->isValid()){
            foreach ($ann->getImagess() as $image){
                $image->setAd($ann);
                $manager->persist($image);
            }
            $user = $this->getUser() ;
            $ann->setUserOwner($user) ;
            
            $ann->setPostedAt(new \DateTime()) ;
            $city = $ann->getLocatedAt() ;
            $city->setAvgPrice(($city->getAvgPrice()*$city->getNbAnnouncements()+$ann->getPrice())/($city->getNbAnnouncements()+1)) ;
            $city->setNbAnnouncements($city->getNbAnnouncements()+1) ;
            $user->addAnnouncement($ann) ;
            $manager->persist($user) ;
            $manager->persist($city);
            $manager->persist($ann) ;
            $manager->flush();
            $this->addFlash(
                'success',
                "Your announce <strong>{$ann->getTitle()}</strong> Has been successfully added"
            );

            return $this->redirectToRoute('ads_show',['slug'=>$ann->getSlug()]);
            //return $this->redirectToRoute('home') ;
        }

        return $this->render('announcement/index.html.twig', [
            'controller_name' => 'AnnouncementController',
            'ad' => $ann ,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/announcement/{slug}/edit", name="ads_edit")
     */
    public function edit(Request $request , ObjectManager $manager,Announcement $ann)
    {
        if( !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $session = $request->getSession() ;
            $this->addFlash('error' , 'You need to Log In first !');
            return $this->redirectToRoute('security_login') ;

        }
        $form = $this->createForm(AnnouncementType::class , $ann) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted() && $form->isValid() ){
            foreach ($ann->getImagess() as $image){
                $image->setAd($ann);
                $manager->persist($image);
            }
            //$user = $this->getUser() ;
           // $ann->setUserOwner($user) ;

            $ann->setPostedAt(new \DateTime()) ;
            $city = $ann->getLocatedAt() ;
            $city->setAvgPrice(($city->getAvgPrice()*$city->getNbAnnouncements()+$ann->getPrice())/($city->getNbAnnouncements()+1)) ;
            $city->setNbAnnouncements($city->getNbAnnouncements()+1) ;
           // $user->addAnnouncement($ann) ;
            //$manager->persist($user) ;
            $manager->persist($city);
            $manager->persist($ann) ;
            $manager->flush();
            $this->addFlash(
                'success',
                "Your announce <strong>{$ann->getTitle()}</strong> Has been successfully Modified"
            );

            return $this->redirectToRoute('ads_show',['slug'=>$ann->getSlug()]);
            //return $this->redirectToRoute('home') ;
        }


        return $this->render('announcement/edit.html.twig', [
            'controller_name' => 'AnnouncementController',
            'ad' => $ann ,
            'form' => $form->createView()
        ]);
    }








    /**
     * @Route("/ads", name="ads_index")
     */
    public function indexTo(AnnouncementRepository $repository)
    {
        $ads = $repository->findAll();

        return $this->render('announcement/indexTo.html.twig', [
            'ads' => $ads,
        ]);
    }

    private function searchArray($arr , $obj){
        $obj1=null;
        foreach($arr as $obj1 )
            if($obj1===$obj) return true ;
        else
            return false ;
    }



    /**
     * @Route("announcement/apply/{slug}", name="ad_apply" )
     */
    public function apply($slug, AnnouncementRepository $repo ,Request $request , ObjectManager $manager ){
        if( !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $session = $request->getSession() ;
            $this->addFlash('error' , 'You need to Log In first !');
            return $this->redirectToRoute('security_login') ;

        }
        
        $ad=$repo->findOneBySlug($slug) ;
        $user=$this->getUser();
        if( (count($ad->getColloc()) < $ad->getMaxRoomates()) && !$user->getAppliedAnn()){
            $ad->addColloc($user) ;
            $user->setAppliedAnn($ad) ;
            $this->addFlash('application' , 'Your application is saved successfully !');
            $manager->persist($ad) ;
            $manager->persist($user) ;
            $manager->flush() ;
            return $this->redirectToRoute('ads_show' , ['slug' => $slug]) ;
        }
        $this->addFlash('error2' , 'You have already applied to an announcement !');
        return $this->redirectToRoute('ads_show' , ['slug' => $slug]) ;


    }
    /**
     * @Route("/announcement/{slug}",name="ads_show")
     *
     */
    public function show($slug, AnnouncementRepository $repository ){
        $ad = $repository->findOneBySlug($slug);
        $ads = $repository->findAll() ;
        $int = 0 ;
        foreach($ads as $add){
            if ($add->getUserOwner() === $ad->getUserOwner())
            $int++ ;
        }

        return $this->render('announcement/show.html.twig',[
            'ad'=>$ad ,
            'int' =>$int
        ]);
    }
}

