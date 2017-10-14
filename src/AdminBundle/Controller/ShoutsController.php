<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ShoutsController extends Controller
{
    /**
     * @Route("admin/shouts", name="admin_shouts_list")
     */
    public function listAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$shout = $em->getRepository('AppBundle:Shout')->findShoutByTitle($request->get('search'));
    	return $this->render('AdminBundle:shouts:list.html.twig', [
        	'shout' => $shout,
            'search' => $request->get('search')
            // ...
        ]);
    }

}
