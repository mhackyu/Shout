<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function indexAction()
    {
       // dump("Asd");die;
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')
         ->findAll();
        $shouts = $em->getRepository('AppBundle:Shout')
         ->findAll();
        $quotes = $em->getRepository('AppBundle:Quote')
         ->findAll();
        
        return $this->render('AdminBundle:Default:index.html.twig', [
            'users' => count($users), 'shouts' => count($shouts), 'quotes' => count($quotes)]);
        
    }

   
    
        

    
}



