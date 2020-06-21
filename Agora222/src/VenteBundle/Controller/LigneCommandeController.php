<?php

namespace VenteBundle\Controller;

use VenteBundle\Entity\LigneCommande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lignecommande controller.
 *
 */
class LigneCommandeController extends Controller
{
    /**
     * Lists all ligneCommande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ligneCommandes = $em->getRepository('VenteBundle:LigneCommande')->findAll();

        return $this->render('lignecommande/index.html.twig', array(
            'ligneCommandes' => $ligneCommandes,
        ));
    }

    /**
     * Creates a new ligneCommande entity.
     *
     */
    public function newAction(Request $request)
    {
        $ligneCommande = new Lignecommande();
        $form = $this->createForm('VenteBundle\Form\LigneCommandeType', $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ligneCommande);
            $em->flush();

            return $this->redirectToRoute('lignecommande_show', array('id' => $ligneCommande->getId()));
        }

        return $this->render('lignecommande/new.html.twig', array(
            'ligneCommande' => $ligneCommande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ligneCommande entity.
     *
     */
    public function showAction(LigneCommande $ligneCommande)
    {
        $deleteForm = $this->createDeleteForm($ligneCommande);

        return $this->render('lignecommande/show.html.twig', array(
            'ligneCommande' => $ligneCommande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ligneCommande entity.
     *
     */
    public function editAction(Request $request, LigneCommande $ligneCommande)
    {
        $deleteForm = $this->createDeleteForm($ligneCommande);
        $editForm = $this->createForm('VenteBundle\Form\LigneCommandeType', $ligneCommande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lignecommande_edit', array('id' => $ligneCommande->getId()));
        }

        return $this->render('lignecommande/edit.html.twig', array(
            'ligneCommande' => $ligneCommande,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ligneCommande entity.
     *
     */
    public function deleteAction(Request $request, LigneCommande $ligneCommande)
    {
        $form = $this->createDeleteForm($ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ligneCommande);
            $em->flush();
        }

        return $this->redirectToRoute('lignecommande_index');
    }

    /**
     * Creates a form to delete a ligneCommande entity.
     *
     * @param LigneCommande $ligneCommande The ligneCommande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LigneCommande $ligneCommande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lignecommande_delete', array('id' => $ligneCommande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
