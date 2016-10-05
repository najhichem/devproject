<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Pays;
use AppBundle\Form\PaysType;

/**
 * Pays controller.
 *
 * @Route("/pays")
 */
class PaysController extends Controller
{
    /**
     * Lists all Pays entities.
     *
     * @Route("/", name="pays_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('AppBundle:Pays')->findAll();

        return $this->render('pays/index.html.twig', array(
            'pays' => $pays,
        ));
    }

    /**
     * Creates a new Pays entity.
     *
     * @Route("/new", name="pays_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pay = new Pays();
        $form = $this->createForm('AppBundle\Form\PaysType', $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pay);
            $em->flush();

            return $this->redirectToRoute('pays_show', array('id' => $pay->getId()));
        }

        return $this->render('pays/new.html.twig', array(
            'pay' => $pay,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pays entity.
     *
     * @Route("/{id}", name="pays_show")
     * @Method("GET")
     */
    public function showAction(Pays $pay)
    {
        $deleteForm = $this->createDeleteForm($pay);

        return $this->render('pays/show.html.twig', array(
            'pay' => $pay,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pays entity.
     *
     * @Route("/{id}/edit", name="pays_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pays $pay)
    {
        $deleteForm = $this->createDeleteForm($pay);
        $editForm = $this->createForm('AppBundle\Form\PaysType', $pay);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pay);
            $em->flush();

            return $this->redirectToRoute('pays_edit', array('id' => $pay->getId()));
        }

        return $this->render('pays/edit.html.twig', array(
            'pay' => $pay,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pays entity.
     *
     * @Route("/{id}", name="pays_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pays $pay)
    {
        $form = $this->createDeleteForm($pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pay);
            $em->flush();
        }

        return $this->redirectToRoute('pays_index');
    }

    /**
     * Creates a form to delete a Pays entity.
     *
     * @param Pays $pay The Pays entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pays $pay)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pays_delete', array('id' => $pay->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
