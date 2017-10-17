<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Love;
use AppBundle\Entity\Shout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoveController
 * Controller used to manage love reaction of users.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class LoveController extends Controller
{
    /**
     * @Route("/love/{slug}/add")
     * @Method("GET")
     */
    public function newAction(Request $request, Shout $shout)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $love = new Love();
            $love->setShout($shout);
            $love->setUser($this->getUser());

            $em->persist($love);
            $em->flush();

            return new Response("success");
        }

        return new Response("failed");
    }

    /**
     * @Route("/love/{slug}/remove")
     * @Method("GET")
     */
    public function removeAction(Request $request, Shout $shout)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $love = $em->getRepository('AppBundle:Love')
                ->findOneBy([
                    'shout' => $shout,
                    'user' => $this->getUser()
                ]);
            if ($love) {
                $em->remove($love);
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
