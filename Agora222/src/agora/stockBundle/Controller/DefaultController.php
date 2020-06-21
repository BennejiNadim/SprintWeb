<?php

namespace agora\stockBundle\Controller;

use agora\stockBundle\Entity\Produit;
use agora\stockBundle\Entity\Marque;
use agora\stockBundle\Entity\Categorie;
use ClubBundle\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@stock/Default/index.html.twig');
    }

    public function listProductsAction(Request $request)
    {

            $produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
            $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
            $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function listProductsByCatgAction(Request $request,$catg)
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->ProduitCatg($catg);
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function listProductsByMarqAction(Request $request,$marq)
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->ProduitMarq($marq);
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function searchProductsAction(Request $req)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        if($req->isMethod('POST')){
            $p=$req->request->get('produit');
            if($p==null){
                $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
            }else {
                $produits = $this->getDoctrine()->getRepository(Produit::class)->FindProducts($p);
            }
        }
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function FilterProducts1Action(Request $req)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        $produits=$this->getDoctrine()->getRepository(Produit::class)->FilterByPrice1();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function FilterProducts2Action(Request $req)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        $produits=$this->getDoctrine()->getRepository(Produit::class)->FilterByPrice2();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function FilterProducts3Action(Request $req)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        $produits=$this->getDoctrine()->getRepository(Produit::class)->FilterByPrice3();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function FilterProducts4Action(Request $req)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        $produits=$this->getDoctrine()->getRepository(Produit::class)->FilterByPrice4();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function FilterProducts5Action(Request $req)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->ListCatg();
        $marques=$this->getDoctrine()->getRepository(Marque::class)->ListMarque();
        $produits=$this->getDoctrine()->getRepository(Produit::class)->FilterByPrice5();
        return $this->render('@stock/products.html.twig',array('produits'=>$produits,'categories'=>$categories,'marques'=>$marques));
    }
    public function contactAction()
    {
        return $this->render('@stock/contact.html.twig');
    }

        public function createAction(Request $request)
    {

        $contact = new Contact;
        # Add form fields
        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class, array('label'=> 'name', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('email', TextType::class, array('label'=> 'email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('message', TextareaType::class, array('label'=> 'message','attr' => array('class' => 'form-control')))
            ->add('Save', SubmitType::class, array('label'=> 'submit', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:15px')))
            ->getForm();
        # Handle form response
        $form->handleRequest($request);
    }
    public function sendMailAction(Request $req)
    {
        require_once 'vendor/autoload.php';

// Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587))
            ->setUsername('agoraacorps@gmail.com')
            ->setPassword('agoraone123')
        ;

// Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

// Create a message
        $message = (new Swift_Message('feedback'))
            ->setFrom(['agoracorps@gmail.com' => $req->get('Name')])
            ->setTo(['agoracorps@gmail.com', 'other@domain.org' => $req->get('Name')])
            ->setBody($req->get('Message'))
        ;

// Send the message
        $result = $mailer->send($message);

    }

}
