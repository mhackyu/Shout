<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Quote;
use AppBundle\Form\QuoteType;
use Symfony\Component\HttpFoundation\Request;


class QuotesController extends Controller
{
    /**
     * @Route("admin/quotes", name="admin_quotes_list")
     */
    public function listAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$quotes = $em->getRepository('AppBundle:Quote')->findAll();
        return $this->render('AdminBundle:quotes:list.html.twig', [
        	'quotes' => $quotes 
            // ...
        ]);
    }


    /**
     * @Route("admin/quotes/new", name="admin_quotes_new")
     */
    public function newAction(Request $request)
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();
            return $this->redirectToRoute('admin_quotes_list');
        }
        return $this->render('AdminBundle:quotes:new.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/quotes/{id}/edit", name="admin_quotes_edit")
     */

    public function editAction(Quote $quote, Request $request)
    {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_quotes_list');
        }
        return $this->render('AdminBundle:quotes:edit.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/quotes/{id}/delete", name="admin_quotes_delete")
     */
    
    public function deleteAction(Quote $quote, Request $request)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($quote);
            $em->flush();
            return $this->redirectToRoute('admin_quotes_list');
        
    }    





}
