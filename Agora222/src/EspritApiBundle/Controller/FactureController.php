<?php

namespace EspritApiBundle\Controller;

use AppBundle\Entity\Facture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FactureController extends Controller
{
    public function allAction()
    {
        $Factures = $this->getDoctrine()->getManager()
            ->getRepository(Facture::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Factures);
        return new JsonResponse($formatted);
    }

    public function clientAction()
    {
        $Factures = $this->getDoctrine()->getManager()
            ->getRepository(Facture::class)
            ->findBy(['clientlogin' => $this->getUser()->getUsername()]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Factures);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $Factures = $this->getDoctrine()->getManager()
            ->getRepository(Facture::class)
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Factures);
        return new JsonResponse($formatted);
    }




}
