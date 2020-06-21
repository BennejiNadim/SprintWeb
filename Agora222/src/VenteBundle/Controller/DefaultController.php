<?php

namespace VenteBundle\Controller;

use AppBundle\Entity\Produit;
use AppBundle\Entity\User;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VenteBundle\Entity\CarteFidelite;
use VenteBundle\Entity\Commande;
use VenteBundle\Entity\LigneCommande;
use VenteBundle\Entity\Livraison;

class DefaultController extends Controller
{
    public function cartefidAction(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $cf = new CarteFidelite();
        $cf->setIdUser($this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $cf->setNbPoint(0);

        $em->persist($cf);
        $em->flush();

        return $this->redirectToRoute('vente_homepage');
    }





    public function panierAction(SessionInterface $session)
    {

        $session->start();
        if ($session->get('panier') == null)
            $session->set('panier',[]);
        $em = $this->getDoctrine()->getManager();
        $panier = $session->get('panier');
        $produits = [];
        foreach ($panier as $p=>$qte){
          //  dump($p);
            $produits[$p] = $em->getRepository(Produit::class)->find($p);
        }

        $cartefid = $em->getRepository(CarteFidelite::class)->findOneBy(['idUser'=>$this->container->get('security.token_storage')->getToken()->getUser()->getId()]);
       // dump($cartefid);
        return $this->render('front\card.html.twig', ["panier"=>$panier, "produits"=>$produits,'cf'=>$cartefid]);
    }


    public function pdfAction(SessionInterface $session)
    {
        $session->start();
        if ($session->get('panier') == null)
            $session->set('panier',[]);
        $em = $this->getDoctrine()->getManager();
        $panier = $session->get('panier');
        $produits = [];
        foreach ($panier as $p=>$qte){
            dump($p);
            $produits[$p] = $em->getRepository(Produit::class)->find($p);
        }

        $cartefid = $em->getRepository(CarteFidelite::class)->findOneBy(['idUser'=>$this->container->get('security.token_storage')->getToken()->getUser()->getId()]);

        $html = $this->renderView('front\pdf.html.twig', ["panier"=>$panier, "produits"=>$produits,'cf'=>$cartefid]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }


    public function produitAction(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->findAll();


        return $this->render('front\produits.html.twig',['prods'=>$prod]);
    }


    public function calendarAction(){

        return $this->render('front\planning.html.twig');
    }


    public function wsprodAction(){

        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($prod, 'json');
        return new Response($jsonContent);
    }


    public function wsCommandesAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Commande::class)->findBy(['idUser'=>$request->get('user')]);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($prod, 'json',['attributes'=>['id','total','dateSTR']]);
        return new Response($jsonContent);
    }




    public function wsDetailsCommandesAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(LigneCommande::class)->findBy(['idCommande'=>$request->get('idCommande')]);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($prod, 'json',['attributes'=>['id','quantite','idProduit']]);
        return new Response($jsonContent);
    }


    public  function wsCheckOutAction(Request $request,$p){
        $p=rtrim($p,"_");
        $em = $this->getDoctrine()->getManager();
        $lignes = explode("_", $p);
        $panier = [];
        foreach ($lignes as $pp){
            $prod = explode("-", $pp);
            $panier[$prod[0]] = $prod[1];
        }
        $date = new \DateTime();
        $commande = new Commande();
        $commande->setDate($date);
        $commande->setIdUser($request->get('user'));
        $em->persist($commande);
        $l = new Livraison();
        $l->setDistance(1);
        $l->setPrix(1);
        $l->setDate($commande->getDate());
        $l->setCommande($commande);

        $commande->setLivraison($l);

        $em->persist($l);
        $total = 0;
        $em->flush();
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
        $cartefid = $em->getRepository(CarteFidelite::class)->findOneBy(['idUser'=>$request->get('user')]);
        if($cartefid != null){
            $commande->setTotal($total - ($cartefid->getNbPoint()/10));
            $cartefid->setNbPoint($total);

        }




        $em->flush();
        return new Response("");
    }

    public function wsCartefidAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cf = new CarteFidelite();
        $cf->setIdUser($request->get('user'));
        $cf->setNbPoint(0);

        $em->persist($cf);
        $em->flush();

        return new Response("");
    }

    public function wsCartefidPointsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cf = $em->getRepository(CarteFidelite::class)->findOneBy(['idUser'=>$request->get('user')]);
        $pts= -1;
        if($cf != null){
            $pts = $cf->getNbPoint();
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($pts, 'json');
        return new Response($jsonContent);
    }


    public function wsLoginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);
        if ($user) {
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $salt = $user->getSalt();

            if ($encoder->isPasswordValid($user->getPassword(), $request->get('password'), $salt)) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            }
        }
        return new JsonResponse("");
    }
}
