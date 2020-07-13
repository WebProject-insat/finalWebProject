<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use App\Repository\CityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @Route("/city/{slug}", name="city")
     */
    public function index(Request $request , ObjectManager $manager , CityRepository $cityRepo , AnnouncementRepository $annRepo , $slug)
    {

        $city=$cityRepo->findOneBySlug($slug) ;
        if(!$city){
            $session = $request->getSession() ;
            $this->addFlash('errorCityId' , 'There is no such a path !');
            return $this->redirectToRoute('home') ;
        }
        $announcements = $annRepo->findBy(['locatedAt' => $city]) ;
        return $this->render('city/index.html.twig', [
            'controller_name' => 'CityController',
            'announcements' => $announcements
        ]);
    }
}
