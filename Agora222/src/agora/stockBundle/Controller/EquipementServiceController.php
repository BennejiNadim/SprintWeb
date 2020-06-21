<?php


namespace agora\stockBundle\Controller;


use App\Entity\Vehicule;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Historiqueequipements;
use AppBundle\Entity\Materiels;
use AppBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EquipementServiceController extends Controller
{
    public function affichervehiculeAction()

    {
        $vehicule=$this->getDoctrine()->getRepository(\AppBundle\Entity\Vehicule::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($vehicule);
        return new JsonResponse($formated);
    }

    public function ajoutvehiculeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $vehicule= new \AppBundle\Entity\Vehicule();
        $vehicule->setNom($request->get("nom"));
        $vehicule->setMatricule($request->get("matricule"));
        $vehicule->setCouleur($request->get("couleur"));
        $vehicule->setUtilisation($request->get("utilisation"));
        $vehicule->setKm($request->get("km"));
        $vehicule->setEtat($request->get("etat"));
        $em->persist($vehicule);
        $em->flush();

        $histo = new Historiqueequipements();

        $histo->setDate((new \DateTime())->format('Y-m-d'));
        $histo->setEquipement('vehicule');
        $histo->setIdV($vehicule->getId());
        $histo->setIdM(0);
        $histo->setOperation('achat');
        $histo->setPrix($request->get("prix"));
        $histo->setQte(1);

        $f = new Facture();

        $f->setDatefacturation(new \DateTime());
        $f->setClientlogin("");
        $f->setEmployelogin("");
        $f->setSupplierid(0);
        $f->setEtatfacture("payed");
        $f->setTypefacture("achat_materiel");
        $f->setMontant($request->get("prix"));
        $em->persist($f);
        $em->flush();


        $histo->setIdf($f->getId());

        $em->persist($histo);
        $em->flush();

        $trans=new Transaction();
        $trans->setDate(new \DateTime());
        $trans->setDescription("");
        $trans->setEtattransaction("payed");
        $trans->setIdfacture($f->getId());
        $trans->setMonton($f->getMontant());

        $em->persist($trans);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($vehicule);
        return new JsonResponse($formated);
    }

    public function supprimervehiculeAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $vehicule=$em->getRepository(\AppBundle\Entity\Vehicule::class)->find($request->get("id"));
        $em->remove($vehicule);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($vehicule);
        return new JsonResponse($formated);
    }

    public function modifiervehiculeAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $vehicule=$em->getRepository(\AppBundle\Entity\Vehicule::class)->find($request->get("id"));
        $em= $this->getDoctrine()->getManager();
        $vehicule->setNom($request->get("nom"));
        $vehicule->setMatricule($request->get("matricule"));
        $vehicule->setCouleur($request->get("couleur"));
        $vehicule->setUtilisation($request->get("utilisation"));
        $vehicule->setKm($request->get("km"));
        $vehicule->setEtat($request->get("etat"));
        $em->persist($vehicule);
        $em->flush(); //commit càd l'execution

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($vehicule);
        return new JsonResponse($formated);
    }



    public function afficherMaterielsAction()

    {
        $materiels=$this->getDoctrine()->getRepository(Materiels::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($materiels);
        return new JsonResponse($formated);
    }

    public function ajoutMaterielsAction(Request $request)
    {

        $materiels = new Materiels();
        $em = $this->getDoctrine()->getManager();
        $materiels= new Materiels();
        $materiels->setNom($request->get("nom"));
        $materiels->setQte($request->get("qte"));
        $materiels->setEtat($request->get("etat"));
        $em->persist($materiels);
        $em->flush();
        $histo = new Historiqueequipements();

        $histo->setDate((new \DateTime())->format('Y-m-d'));
        $histo->setEquipement('vehicule');
        $histo->setIdV(0);
        $histo->setIdM($materiels->getId());
        $histo->setOperation('achat');
        $histo->setPrix($request->get("prix"));
        $histo->setQte($materiels->getQte());

        $f = new Facture();

        $f->setDatefacturation(new \DateTime());
        $f->setClientlogin("");
        $f->setEmployelogin("");
        $f->setSupplierid(0);
        $f->setEtatfacture("payed");
        $f->setTypefacture("achat_materiel");
        $f->setMontant($request->get("prix_total"));
        $em->persist($f);
        $em->flush();


        $histo->setIdf($f->getId());

        $em->persist($histo);
        $em->flush();

        $trans=new Transaction();
        $trans->setDate(new \DateTime());
        $trans->setDescription("");
        $trans->setEtattransaction("payed");
        $trans->setIdfacture($f->getId());
        $trans->setMonton($f->getMontant());

        $em->persist($trans);
        $em->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($materiels);
        return new JsonResponse($formated);
    }

    public function supprimerMaterielsAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $materiels=$em->getRepository(Materiels::class)->find($request->get("id"));
        $em->remove($materiels);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($materiels);
        return new JsonResponse($formated);
    }

    public function modifierMaterielsAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $materiels=$em->getRepository(Materiels::class)->find($request->get("id"));
        $em= $this->getDoctrine()->getManager();
        $materiels->setNom($request->get("nom"));
        $materiels->setQte($request->get("qte"));
        $materiels->setEtat($request->get("etat"));
        $em->persist($materiels);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($materiels);
        return new JsonResponse($formated);
    }




    public function afficherhistoriqueequipementAction()

    {
        $he=$this->getDoctrine()->getRepository(Historiqueequipements::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($he);
        return new JsonResponse($formated);
    }



    public function modifierhistoriqueequipementAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $he=$em->getRepository(Historiqueequipements::class)->find($request->get("id"));
        $em= $this->getDoctrine()->getManager();
        $he->setDate($request->get("date"));
        $he->setOperation($request->get("operation"));
        $he->setEquipement($request->get("equipement"));
        $he->setQte($request->get("qte"));
        $he->setIdM($request->get("idm"));
        $he->setIdV($request->get("idv"));
        $he->setPrix($request->get("prix"));
        $he->setIdF($request->get("idf"));
        $em->persist($he);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($he);
        return new JsonResponse($formated);
    }
    public function supprimerhistoriqueAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $he=$em->getRepository(Historiqueequipements::class)->find($request->get("id"));
        $em->remove($he);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($he);
        return new JsonResponse($formated);
    }
}