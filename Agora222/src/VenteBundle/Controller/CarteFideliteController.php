<?php

namespace VenteBundle\Controller;

use VenteBundle\Entity\CarteFidelite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cartefidelite controller.
 *
 */
class CarteFideliteController extends Controller
{
    /**
     * Lists all carteFidelite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carteFidelites = $em->getRepository('VenteBundle:CarteFidelite')->findAll();

        return $this->render('cartefidelite/index.html.twig', array(
            'carteFidelites' => $carteFidelites,
        ));
    }

    /**
     * Creates a new carteFidelite entity.
     *
     */
    public function newAction(Request $request)
    {
        $carteFidelite = new Cartefidelite();
        $form = $this->createForm('VenteBundle\Form\CarteFideliteType', $carteFidelite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carteFidelite);
            $em->flush();

            return $this->redirectToRoute('cartefidelite_show', array('idCf' => $carteFidelite->getIdcf()));
        }

        return $this->render('cartefidelite/new.html.twig', array(
            'carteFidelite' => $carteFidelite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a carteFidelite entity.
     *
     */
    public function showAction(CarteFidelite $carteFidelite)
    {
        $deleteForm = $this->createDeleteForm($carteFidelite);

        return $this->render('cartefidelite/show.html.twig', array(
            'carteFidelite' => $carteFidelite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing carteFidelite entity.
     *
     */
    public function editAction(Request $request, CarteFidelite $carteFidelite)
    {
        $deleteForm = $this->createDeleteForm($carteFidelite);
        $editForm = $this->createForm('VenteBundle\Form\CarteFideliteType', $carteFidelite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cartefidelite_edit', array('idCf' => $carteFidelite->getIdcf()));
        }

        return $this->render('cartefidelite/edit.html.twig', array(
            'carteFidelite' => $carteFidelite,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a carteFidelite entity.
     *
     */
    public function deleteAction(Request $request, CarteFidelite $carteFidelite)
    {
        $form = $this->createDeleteForm($carteFidelite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carteFidelite);
            $em->flush();
        }

        return $this->redirectToRoute('cartefidelite_index');
    }

    /**
     * Creates a form to delete a carteFidelite entity.
     *
     * @param CarteFidelite $carteFidelite The carteFidelite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CarteFidelite $carteFidelite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cartefidelite_delete', array('idCf' => $carteFidelite->getIdcf())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
