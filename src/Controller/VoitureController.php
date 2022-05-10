<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Voiture;
use App\Entity\Marque;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VoitureController.php',
        ]);
    }

    /**
    * @Route("insertVoiture/{modele}/{nb_places}/{marque_id}"),name="insertVoiture",requirements={"modele"="[a-z]{4,30}"},{"nb_places"="[0-9]{5}"},{"marque_id"="[0-9]{5}"}
    */
    public function insert(Request $request,$modele,$nb_places,$marque_id)
    {
      $voit=new Voiture();
      $voit->setModele($modele);
      $voit->setNbplace($nb_places);


      if($request->isMethod('get')){
        $em=$this->getDoctrine()->getManager();
        $marqueRepository=$em->getRepository(Marque::class);
        $marq=$marqueRepository->find($marque_id);
        if ($marq){
          $voit->setMarqueId($marq);
          $em->persist($voit);
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
    * @Route("/deleteVoiture/{id}", name="deleteVoiture",requirements={"id"="[0-9]{1,5}"})
      */
      public function delete(Request $request,$id){
         //récupération du Manager  et du repository pour accéder à la bdd
         $em=$this->getDoctrine()->getManager();
          $voitureRepository=$em->getRepository(Voiture::class);
          //requete de selection
          $voit=$voitureRepository->find($id);
           //suppression de l'entity
          $em->remove($voit); $em->flush();
          $resultat=["ok"];
          $reponse= new JsonResponse($resultat);
          return $reponse;
      }

      /**
      *@Route("/listeVoiture", name="listeVoiture")
      */

      public function liste(Request $request)
      {
      	$em=$this->getDoctrine()->getManager();
      	$voitureRepository=$em->getRepository(Voiture::class);
      	$listeVoitures=$voitureRepository->findAll();
      	$result=[];
      	foreach($listeVoitures as $voit){
      		array_push($result,['id'=>$voit->getId(),"modele"=>$voit->getModele(),"nbplace"=>$voit->getNbPlace(),"marque_id"=>$voit->getMarqueId()->getId()]);
      	}
      	$response=new JsonResponse($result);

      	return $response;
      }

}
