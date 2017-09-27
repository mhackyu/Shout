<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

}
