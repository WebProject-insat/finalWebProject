<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\SearchBarType;
use App\Repository\AnnouncementRepository;
use App\Repository\CityRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class LandingController extends AbstractController
{
    private $session ;
    public function __construct(SessionInterface $session)
    {
        $this->session=$session ;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(CityRepository $cityRepo , AnnouncementRepository $annRepo, ObjectManager $manager , UserRepository $userRepo , Request $request )
    {
        $cities = $cityRepo->findAll() ;
        $announcements = $annRepo->findAll() ;
        foreach($cities as $city){
            $city->setAvgPrice(0) ;
            $city->setNbAnnouncements(0) ;
            foreach($announcements as $ann){
                if($ann->getLocatedAt() === $city ){
                    $city->setAvgPrice($city->getAvgPrice()+$ann->getPrice());
                    $city->setNbAnnouncements($city->getNbAnnouncements()+1) ;
                }
            }
            if($city->getNbAnnouncements() !== 0){
                $city->setAvgPrice($city->getAvgPrice()/$city->getNbAnnouncements()) ;
            }
        }
        foreach ($cities as $city){
            $manager->persist($city);
        }

        $manager->flush();

        $city1 = $cityRepo->findOneBy(['name'=>'Tunis']) ;
        $city2 = $cityRepo->findOneBy(['name'=>'Manouba']) ;
        $city3 = $cityRepo->findOneBy(['name'=>'Ariana']) ;
        $citiess = [$city1 , $city2 , $city3] ;

        $form = $this->createForm(SearchBarType::class , new City() ) ;
        return $this->render('landing/index.html.twig', [
            'controller_name' => 'LandingController',
            'formCity' => $form->createView() ,
            'cities' => $citiess
        ]);
    }
}
