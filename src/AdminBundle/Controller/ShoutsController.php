<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShoutsController extends Controller
{
    /**
     * @Route("admin/shouts", name="admin_shouts_list")
     */
    public function listAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$shout = $em->getRepository('AppBundle:Shout')->findAll();
    	return $this->render('AdminBundle:shouts:list.html.twig', [
        	'shout' => $shout
            // ...
        ]);
    }

}
