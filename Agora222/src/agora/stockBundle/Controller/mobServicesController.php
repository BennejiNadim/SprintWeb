<?php


namespace agora\stockBundle\Controller;



use agora\stockBundle\Entity\Categorie;
use agora\stockBundle\Entity\Marque;
use agora\stockBundle\Entity\Produit;
use agora\stockBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class mobServicesController extends Controller
{
    public function listProductsAction(Request $req){
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);
    }
    public function AddProductAction(Request $req){
        $produit=new Produit();
        $em=$this->getDoctrine()->getManager();
        $produit->setRefProduit($req->get('refProduit'));
        $produit->setNomProduit($req->get('nomProduit'));
        $produit->setMarque($req->get('marque'));
        $produit->setCategorie($req->get('categorie'));
        $produit->setQuantiteStock($req->get('quantiteStock'));
        $produit->setQuantiteMagasin($req->get('quantiteMagasin'));
        $produit->setPrixVente($req->get('prixVente'));
        $produit->setPrixAchat($req->get('prixAchat'));
        $produit->setImage($req->get('image'));
        $produit->setUpdated($req->get('updated'));
        $em->persist($produit);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    public function AllcatgAction(Request $req)
    {
        $catg=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($catg);
        return new JsonResponse($formatted);
    }
    public function AllmarqsAction(Request $req)
    {
        $marq=$this->getDoctrine()->getRepository(Marque::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($marq);
        return new JsonResponse($formatted);
    }
    public function findByCatgAction(Request $req)
    {
        $catg=$req->get('categorie');
        $prod=$this->getDoctrine()->getRepository(Produit::class)->ProduitCatg($catg);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prod);
        return new JsonResponse($formatted);
    }
    public function findByMarqAction(Request $req)
    {
        $marq=$req->get("marque");
        $prod=$this->getDoctrine()->getRepository(Produit::class)->ProduitMarq($marq);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prod);
        return new JsonResponse($formatted);
    }
    public function findProductAction(Request $req)
    {
        $prod=$req->get('nomProduit');
        $produit=$this->getDoctrine()->getRepository(Produit::class)->FindProducts($prod);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    public function findProductByIdAction(Request $req)
    {
        $prod=$req->get('id');
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($prod);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    public function AddRatingAction(Request $req)
    {
        $rate=new Rating();
        $em=$this->getDoctrine()->getManager();
        $rate->setFeedback($req->get('feedback'));
        $rate->setRatings($req->get('ratings'));
        $em->persist($rate);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($rate);
        return new JsonResponse($formatted);

    }
}