<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Personne;
use App\Entity\Ville;
use App\Entity\Voiture;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PersonneController.php',
        ]);
    }


    /**
     * @Route("/insertPersonne/{nom}/{prenom}/{tel}/{email}/{ville_id}/{voiture_id}", name="insertPersonne")
     */
    public function insert(Request $request,$nom,$prenom,$tel,$email,$ville_id,$voiture_id)
    {
      $pers=new Personne();
      $pers->setNom($nom);
      $pers->setPrenom($prenom);
      $pers->setTel($tel);
      $pers->setEmail($email);

      if($request->isMethod('get')){
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
        $vil=$villeRepository->find($ville_id);
        $voitureRepository=$em->getRepository(Voiture::class);
        $voit=$voitureRepository->find($voiture_id);
        if($vil && $voit){
          $pers->setVille($vil);
          $pers->setVoiture($voit);
          $em->persist($pers);
          $em->flush();
          $resultat=["ok"];
        }
        else{
          $resultat=["nok"];
        }
      }
      else{
        $resultat=["nok"];
      }
      $response=new JsonResponse($resultat);
      return $response;

    }
    /**
    * @Route("/deletePersonne/{id}", name="deletePersonne",requirements={"id"="[0-9]{1,5}"})
      */
      public function delete(Request $request,$id){
         //récupération du Manager  et du repository pour accéder à la bdd
         $em=$this->getDoctrine()->getManager();
          $personneRepository=$em->getRepository(Personne::class);
          //requete de selection
          $pers=$personneRepository->find($id);
           //suppression de l'entity
          $em->remove($pers); $em->flush();
          $resultat=["ok"];
          $reponse= new JsonResponse($resultat);
          return $reponse;
      }

      /**
      *@Route("/listePersonne", name="listePersonne")
      */

      public function liste(Request $request)
      {
        $em=$this->getDoctrine()->getManager();
        $personneRepository=$em->getRepository(Personne::class);
        $listePersonne=$personneRepository->findAll();
        $result=[];
        foreach($listePersonne as $pers){
          array_push($result,['id'=>$pers->getId(),"nom"=>$pers->getNom(),"prenom"=>$pers->getPrenom(),"tel"=>$pers->getTel(),"email"=>$pers->getEmail(),"ville_id"=>$pers->getVille()->getId(),"voiture_id"=>$pers->getVoiture()->getId()]);
        }
        $response=new JsonResponse($result);

        return $response;
      }
}
