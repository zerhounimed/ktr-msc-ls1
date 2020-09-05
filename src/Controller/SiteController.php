<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class SiteController extends AbstractController
{

    /**
     * cette methode permet l'affichage du profile de l'utilisateur
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        $repo = $this->getDoctrine()->getRepository(Card::class);

        $profile = $repo->find(12);

        return $this->render('site/profile.html.twig', [
            'profile' => $profile
        ]);
    }


    /**
     * Methode pour enregitrer la carte visite d'utlilisateur et pouvoir la modifier
     *
     * @Route("/inscription", name="registration")
     * @Route("/info_{id}_edit", name="user_edit")
     */
    public function registration(Request $request, EntityManagerInterface $manager)
    {

        $profile = new Profile();

        $form = $this->createFormBuilder($profile)
            ->add('name')
            ->add('companyName')
            ->add('email')
            ->add('telephone')
            ->add('save', SubmitType::class, [
                'label' => 'Save'
            ])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($profile);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('site/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * cette methode permet l'affichage de tous les cartes
     * @Route("/site", name="site")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Card::class);

        $cards = $repo->findAll();

        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'cards' => $cards
        ]);
    }

    /**
     * La page d'acceiul de l'application
     * @Route ("/" , name="home" )
     */

    public function home()
    {
        return $this->render('site/home.html.twig');
    }

    /**
     * cette methode permet de créer une nouvelle carte visite
     *
     * @Route("/site/newcard", name="card_create")
     */

    public function create(Request $request, EntityManagerInterface $manager)
    {

        $card = new Card();

        $form = $this->createFormBuilder($card)
            ->add('name')
            ->add('companyName')
            ->add('email')
            ->add('telephone')
            ->add('save', SubmitType::class, [
                'label' => 'Save'
            ])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($card);
            $manager->flush();

            return $this->redirectToRoute('site');
        }


        /*
        if($request->request->count() > 0){
            $card-> setName($request->request->get('name'))
                ->setCompanyName($request->request->get('nameCompany'))
                ->setEmail($request->request->get('email'))
                ->setTelephone($request->request->get('telephone'));

            $manager->persist($card);
            $manager->flush();
        return $this->redirectToRoute ('site');
        }
        */


        return $this->render('site/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *cette methode permet l'affichage d'une seule carte
     * @Route("/site/{id}", name="card_show")
     */

    public function show($id)
    {

        $repo = $this->getDoctrine()->getRepository(Card::class);

        $card = $repo->find($id);

        return $this->render('site/show.html.twig', [
            'card' => $card
        ]);
    }

}


