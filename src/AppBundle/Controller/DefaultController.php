<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // prevent authenticated user to access landing page.
        $authChecker = $this->get('security.authorization_checker');

        // get qoute of the day
        $em = $this->getDoctrine()->getManager();
        $quote = $em->getRepository('AppBundle:Quote')->quoteOfTheDay();

        if ($authChecker->isGranted("IS_AUTHENTICATED_FULLY")) {
            return $this->redirectToRoute('shout_list');
        }

        return $this->render("default/landing.html.twig", [
            'quote' => $quote
        ]);
    }
}
