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

    /**
     * @Route("/send")
     */
    public function sendAction(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Welcome to Shout!'))
            ->setFrom('contactshoutee@gmail.com','Team Shout')
            ->setTo('markpaderes0932@yahoo.com')
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig', ['name' => 'mhackyu']
                ),
                'text/html'
            );
        /*
          * If you also want to include a plaintext version of the message
         ->addPart(
             $this->renderView(
                 'Emails/registration.txt.twig',
                 array('name' => $name)
             ),
             'text/plain'
         )
         */
        $mailer->send($message);
        dump($mailer);die;
    }
}
