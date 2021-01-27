<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjectType;
use App\Repository\ProjetRepository;
use phpDocumentor\Reflection\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(ProjetRepository $repo): Response
    {
        $projets=$repo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'projets' =>$projets
        ]);
    }
    /**
     * @Route("/",name="home")
     */
    public function home() {
        return $this->render('home/home.html.twig');
    }



    /**
     * @route("/home/new", name="projet_create")
     * @route("/home/{id}/edit", name="home_edit")
     */

    public function form(Projet $projet = null, Request $request, 
    EntityManagerInterface $manager){

        if(!$projet){
          $projet = new Projet();  
        }

        $form = $this->createForm(ProjectType::class, $projet);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

                $manager->persist($projet);
                $manager->flush();

                return $this->redirectToRoute('home_show', ['id' => $projet->getId()]);
        }

        return $this->render('home/create.html.twig', [
            'formProjet' => $form->createView(),
            'editMode' => $projet->getId() !==null
        ]);
        
    }



    /**
     * @Route("/home/projet/{id}", name="home_show")
     */
    public function show(Projet $projet){

        return $this->render('home/show.html.twig', [
            'projet' =>$projet
        ]);
    }


    /**
    * @Route("home/remove/{id}", name="remove_project")
    */
    public function remove(Projet $projet): Response{

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($projet);
        $entityManager->flush();
        return $this->redirectToRoute('index');

    }
}