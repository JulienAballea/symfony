<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Trajet;
use App\Entity\Personne;
use App\Entity\Ville;


class TrajetController extends AbstractController
{
    /**
     * @Route("/trajet", name="trajet")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TrajetController.php',
        ]);
    }


    /**
     * @Route("/insertTrajet/{nbKms}/{datetrajet}/{ville_dep}/{ville_arr}", name="insertTrajet")
     */
    public function insert(Request $request,$nbKms,$datetrajet,$ville_dep,$ville_arr)
    {
      $traj=new Trajet();
      $traj->setNbKms($nbKms);
      $traj->setDatetrajet($datetrajet)->format('Y-m-d h:m:s');


      if($request->isMethod('get')){
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
        $vila=$villeRepository->find($ville_arr);
        $vild=$villeRepository->find($ville_dep);
        if( $vila && $vild){
          $traj->setVilleArr($vila);
          $traj->setVilleDep($vild);
          $em->persist($traj);
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
    * @Route("/deleteTrajet/{id}", name="deleteTrajet",requirements={"id"="[0-9]{1,5}"})
      */
      public function delete(Request $request,$id){
         //récupération du Manager  et du repository pour accéder à la bdd
         $em=$this->getDoctrine()->getManager();
          $trajetRepository=$em->getRepository(Trajet::class);
          //requete de selection
          $traj=$trajetRepository->find($id);
           //suppression de l'entity
          $em->remove($traj); $em->flush();
          $resultat=["ok"];
          $reponse= new JsonResponse($resultat);
          return $reponse;
      }

      /**
      *@Route("/listeTrajet", name="listeTrajet")
      */

      public function liste(Request $request)
      {
        $em=$this->getDoctrine()->getManager();
        $trajonneRepository=$em->getRepository(Trajet::class);
        $listeTrajet=$trajonneRepository->findAll();
        $result=[];
        foreach($listeTrajet as $traj){
          array_push($result,['id'=>$traj->getId(),"nom"=>$traj->getNom(),"prenom"=>$traj->getPrenom(),"tel"=>$traj->getTel(),"email"=>$traj->getEmail(),"ville_id"=>$traj->getVille()->getId(),"voiture_id"=>$traj->getVoiture()->getId()]);
        }
        $response=new JsonResponse($result);

        return $response;
      }
}
