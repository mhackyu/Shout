<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShoutController extends Controller
{

    /**
     * @Route("/shout", name="shout_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $shouts = $em->getRepository('AppBundle:Shout')->findAll();

        return $this->render('shout/list.html.twig', [
            'shouts' => $shouts
        ]);
    }

}
