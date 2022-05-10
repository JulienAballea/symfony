<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ville;

class VilleController extends AbstractController
{
    /**
     * @Route("/ville", name="ville")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VilleController.php',
        ]);
    }
    /**
    * @Route("insertVille/{ville}/{codepostal}"),name="insertVille",requirements={"ville"="[a-z]{4,30}"},{"codepostal"="[0-9]{5}"}
    */
    public function insert(Request $request,$ville,$codepostal)
    {
      $vil=new Ville();
      $vil->setVille($ville);
      $vil->setCodepostal($codepostal);

      if($request->isMethod('get')){
        $em=$this->getDoctrine()->getManager();
        $em->persist($vil);
        $em->flush();
        $resultat=["ok"];
      }
      else{
        $resultat=["nok"];
      }
      $response=new JsonResponse($resultat);
      return $response;

    }
    /**
    * @Route("/deleteVille/{id}", name="deleteVille",requirements={"id"="[0-9]{1,5}"})
      */
      public function delete(Request $request,$id){
         //récupération du Manager  et du repository pour accéder à la bdd
         $em=$this->getDoctrine()->getManager(); $villeRepository=$em->getRepository(Ville::class);
          //requete de selection
          $vil=$villeRepository->find($id);
           //suppression de l'entity
          $em->remove($vil); $em->flush();
          $resultat=["ok"];
          $reponse= new JsonResponse($resultat);
          return $reponse;
      }

      /**
      *@Route("/listeVille", name="listeVille")
      */

      public function liste(Request $request)
      {
      	$em=$this->getDoctrine()->getManager();
      	$villeRepository=$em->getRepository(Ville::class);
      	$listeVilles=$villeRepository->findAll();
      	$result=[];
      	foreach($listeVilles as $vil){
      		array_push($result,['id'=>$vil->getId(),'ville'=>$vil->getVille(),'codepostal'=>$vil->getCodepostal()]);
      	}
      	$response=new JsonResponse($result);

      	return $response;
      }
}
