<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Inscription;
use App\Entity\Trajet;
use App\Entity\Personne;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/InscriptionController.php',
        ]);
    }

    /**
     * @Route("/insertInscription/{pers}/{trajet}", name="insertInscription")
     */
    public function insert(Request $request,$pers,$trajet)
    {
      $insc=new Inscription();

      if($request->isMethod('get')){
        $em=$this->getDoctrine()->getManager();
        $trajetRepository=$em->getRepository(Trajet::class);
        $traj=$trajetRepository->find($trajet);
        $personneRepository=$em->getRepository(Personne::class);
        $perso=$personneRepository->find($pers);
        if( $perso && $traj){
          $insc->setTrajet($traj);
          $insc->setPersonne($perso);
          $em->persist($insc);
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
    * @Route("/deleteInscription/{id}", name="deleteInscription",requirements={"id"="[0-9]{1,5}"})
    */
    public function delete(Request $request,$id){
       //récupération du Manager  et du repository pour accéder à la bdd
       $em=$this->getDoctrine()->getManager();
        $inscriptionRepository=$em->getRepository(Inscription::class);
        //requete de selection
        $inscri=$inscriptionRepository->find($id);
         //suppression de l'entity
        $em->remove($inscri); $em->flush();
        $resultat=["ok"];
        $reponse= new JsonResponse($resultat);
        return $reponse;
    }

    /**
    *@Route("/listeInscription", name="listeInscription")
    */

    public function liste(Request $request)
    {
      $em=$this->getDoctrine()->getManager();
      $inscriptionRepository=$em->getRepository(Inscription::class);
      $listeInscription=$inscriptionRepository->findAll();
      $result=[];
      foreach($listeInscription as $insc){
        array_push($result,['id'=>$insc->getId(),"trajet"=>$insc->getTrajet()->getId(),"personne"=>$insc->getPersonne()->getId()]);
      }
      $response=new JsonResponse($result);

      return $response;
    }
}
