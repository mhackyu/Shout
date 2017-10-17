<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advice;
use AppBundle\Entity\FoundHelpful;
use AppBundle\Entity\Shout;
use AppBundle\Form\AdviceFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdviceController
 * Controller used to manage advice of the users.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class AdviceController extends Controller
{
    /**
     * @Route("/advice/{slug}/new", name="advice_new")
     * @Method("POST")
     */
    public function newAction(Request $request, Shout $shout)
    {
//        $em = $this->getDoctrine()->getManager();
//        $advice = new Advice();
//        $form = $this->createForm(AdviceFormType::class, $advice);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $advice->setUser($this->getUser());
//            $em->persist($advice);
//            $em->flush();
//
//            $this->redirectToRoute('shout_show', ['slug' => $shout->getSlug()]);
//        }
//
//        $this->redirectToRoute('shout_show', ['slug' => $shout->getSlug()]);
        dump($shout);die;
    }

    /**
     * @Route("/advice/{id}/show", name="advice_show")
     */
    public function showAction(Advice $advice)
    {
        // This will get the rank of the advice
        $rank = 1;
        $em = $this->getDoctrine()->getManager();
        $topAdvices = $em->getRepository('AppBundle:Advice')
            ->topAdvicesWithin(new \DateTime("now-1week"), new \DateTime("now"));

        foreach ($topAdvices as $value) {
            if ($value['id'] == $advice->getId()) {
                break;
            }
            $rank++;
        }

        return $this->render("advice/show.html.twig", [
            'shout' => $advice->getShout(),
            'advice' => $advice,
            'rank' => $rank
        ]);
    }

    /**
     * @Route("/advice/{id}/helpful", name="advice_add_helpful")
     * @Method("POST")
     */
    public function foundHelpfulAddAction(Request $request, Advice $advice)
    {
        if ($request->isXmlHttpRequest()) {
            $helpful = new FoundHelpful();
            $helpful->setAdvice($advice);
            $helpful->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($helpful);
            $em->flush();

            return new Response("success");
        }

        return new Response("failed");

    }

    /**
     * @Route("/advice/{id}/remove-helpful", name="advice_remove_helpful")
     * @Method("POST")
     */
    public function foundHelpfulRemoveAction(Request $request, Advice $advice)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $foundHelpful = $em->getRepository('AppBundle:FoundHelpful')
                ->findOneBy([
                    'advice' => $advice,
                    'user' => $this->getUser()
                ]);
            if ($foundHelpful) {
                $em->remove($foundHelpful);
                $em->flush();
                return new Response("success");
            }
            else {
                return new Response("failed");
            }
        }

        return new Response("failed");
    }

    /**
     * @Route("/advice/{id}/remove", name="advice_remove")
     */
    public function removeAction(Advice $advice)
    {
        $em = $this->getDoctrine()->getManager();
        $shout = $advice->getShout();
        $em->remove($advice);
        $em->flush();

        return $this->redirectToRoute('shout_show', ['slug' => $shout->getSlug()]);
    }

}
