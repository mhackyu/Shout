<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShouteeController extends Controller
{
    /**
     * @Route("/shoutees/", name="shoutee_search")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod("GET")) {
            $search = $request->get('search');
           $shoutees = $em->getRepository('AppBundle:User')->searchUser($search);
            return $this->render('shoutee/search.html.twig', [
                'shoutees' => $shoutees
            ]);
        }
//        return $this->render('', array('name' => $name));
    }
}
