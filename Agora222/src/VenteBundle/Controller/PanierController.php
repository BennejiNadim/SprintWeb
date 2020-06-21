<?php

namespace VenteBundle\Controller;

use AppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use VenteBundle\Entity\CarteFidelite;
use VenteBundle\Entity\Commande;
use VenteBundle\Entity\LigneCommande;
use VenteBundle\Entity\Livraison;


class PanierController extends Controller
{

    public function addProduitAction(SessionInterface $session,$idp, $qte){

        $session->start();
        if ($session->get('panier') == null)
            $session->set('panier',[]);

        $panier = $session->get('panier');



        if(isset($panier[$idp])){
            if($qte + $panier[$idp]<0)
                $panier[$idp] = 0;
            else
                $panier[$idp] += $qte;
        }
        else {
            $panier[$idp] = $qte;
        }


        $session->set('panier',$panier);

        return new JsonResponse(sizeof($panier));


    }





    public function setProduitAction(SessionInterface $session,$idp, $qte){

        $em = $this->getDoctrine()->getManager();
        $session->start();
        if ($session->get('panier') == null)
            $session->set('panier',[]);
        $panier = $session->get('panier');

        $panier[$idp] = $qte;

        $session->set('panier',$panier);
        $total = 0;
        foreach ($panier as $k=>$v){
            $total += $v * $em->getRepository(Produit::class)->find($k)->getPrixVente();
        }
        return new JsonResponse($total);
    }

    public function CheckOutAction(Request $request, SessionInterface $session){

        $em = $this->getDoctrine()->getManager();
        $session->start();
        if ($session->get('panier') == null)
            $session->set('panier',[]);
        $panier = $session->get('panier');
        $date = new \DateTime();
        $commande = new Commande();
        $commande->setDate($date);
        $commande->setIdUser($this->getUser());
        $em->persist($commande);
        if($request->get('islivraison') == "true") {
            $l = new Livraison();
            $nbDays = round($request->get("distance")/60);
            $dd = $commande->getDate()->modify('+'.$nbDays." day");

            $l->setDate($dd);
            $l->setCommande($commande);
            $l->setDistance($request->get("distance"));
            $l->setPrix($l->getDistance()*5);
            $commande->setLivraison($l);

            $em->persist($l);
        }
        $total = 0;
        foreach ($panier as $k=>$v){
            $prod = $em->getRepository(Produit::class)->find($k);
            $ligne = new LigneCommande();
            $ligne->setIdCommande($commande->getId());
            $ligne->setIdProduit($prod->getRefProduit());
            $ligne->setQuantite($v);
            $em->persist($ligne);
            $total+= $v*$prod->getPrixVente();
            //$commande->addLigne($ligne);
        }
        $commande->setTotal($total);
        $cartefid = $em->getRepository(CarteFidelite::class)->findOneBy(['idUser'=>$this->container->get('security.token_storage')->getToken()->getUser()->getId()]);
        if($cartefid != null){
            $commande->setTotal($total - ($cartefid->getNbPoint()/10));
            $cartefid->setNbPoint($total);

        }
        $this->addFlash('succès',"Commande effectuée! ");




        $em->flush();
        $session->clear();



        return $this->redirectToRoute('calendar');
    }

    public function distanceAction($ville){

        $response = \Unirest\Request::get('https://fr.distance24.org/route.json?stops=Ariana|'.$ville);

        return new Response($response->body->distance);

    }



}
