<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Loud;
use AppBundle\Entity\Shout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoudController
 * Controller used to managed loud reaction of users.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class LoudController extends Controller
{
    /**
     * @Route("/loud/{slug}/add")
     * @Method("GET")
     */
    public function newAction(Request $request, Shout $shout)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $loud = new Loud();
            $loud->setShout($shout);
            $loud->setUser($this->getUser());

            $em->persist($loud);
            $em->flush();

            return new Response("success");
        }

        return new Response("failed");
    }

    /**
     * @Route("/loud/{slug}/remove")
     * @Method("GET")
     */
    public function removeAction(Request $request, Shout $shout)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $loud = $em->getRepository('AppBundle:Loud')
                ->findOneBy([
                    'shout' => $shout,
                    'user' => $this->getUser()
                ]);
            if ($loud) {
                $em->remove($loud);
                $em->flush();
                return new Response("success");
            }
            else {
                return new Response("failed");
            }
        }

        return new Response("failed");
    }
}
