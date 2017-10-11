<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("my-shouts")
 */
class MyShoutController extends Controller
{
    /**
     * @Route("/", name="my_shout_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $shouts = $em->getRepository('AppBundle:Shout')
            ->findBy([
                'user' => $this->getUser()
            ]);

        return $this->render('myShouts/list.html.twig', [
            'shouts' => $shouts
        ]);
    }
}
