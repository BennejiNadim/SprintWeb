<?php

namespace EspritApiBundle\Controller;

use AppBundle\Entity\Facture;
use AppBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TransactionController extends Controller
{
    public function allAction()
    {
        $Transaction = $this->getDoctrine()->getManager()
            ->getRepository(Transaction::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Transaction);
        return new JsonResponse($formatted);
    }

    public function clientAction()
    {
        $Factures = $this->getDoctrine()->getManager()
            ->getRepository(Transaction::class)
            ->findBy(['clientlogin' => $this->getUser()->getUsername()]);
        $ids = array();
        foreach ($Factures as $f){
        array_push($ids,$f->getId());
        }

        $Transaction = $this->getDoctrine()->getManager()
            ->getRepository(Transaction::class)
            ->findBy(['idfacture' => $ids]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Transaction);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $Transaction = $this->getDoctrine()->getManager()
            ->getRepository(Transaction::class)
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Transaction);
        return new JsonResponse($formatted);
    }
}
