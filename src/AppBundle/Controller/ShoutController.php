<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advice;
use AppBundle\Entity\Shout;
use AppBundle\Form\AdviceFormType;
use AppBundle\Form\ShoutType;
use AppBundle\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShoutController
 * Controller used to manage shout contents in the public part of the site
 * @author Mark Christian E. Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 * @Route("/shout")
 */
class ShoutController extends Controller
{
    /**
     * @Route("/", name="shout_list")
     */
    public function listAction(Request $request, Slugger $slugger)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod("GET")) {
            $search = $request->get('search');
            if ($search) {
                $results = $em->getRepository('AppBundle:User')->searchUser($search);
                dump($results);
            }
        }

        $shouts = $em->getRepository('AppBundle:Shout')->shouts();
        $shout = new Shout();
        $form = $this->createForm(ShoutType::class, $shout);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $shout->setSlug($slugger->slugify());
                $shout->setUser($this->getUser());
                $em->persist($shout);
                $em->flush();

                return $this->redirectToRoute('shout_list');
            }
        }
        return $this->render('shout/list.html.twig', [
            'shouts' => $shouts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="shout_new")
     */
    public function newAction(Request $request, Slugger $slugger)
    {
        $shout = new Shout();
        $form = $this->createForm(ShoutType::class, $shout);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shout->setSlug($slugger->slugify());
            $shout->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($shout);
            $em->flush();

            return $this->redirectToRoute('shout_list');
        }

        return $this->render('shout/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{slug}", name="shout_show")
     * @Method({"POST", "GET"})
     */
    public function showAction(Request $request, Shout $shout)
    {
        $em = $this->getDoctrine()->getManager();
        $advice = new Advice();
        $form = $this->createForm(AdviceFormType::class, $advice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $advice->setShout($shout);
            $advice->setUser($this->getUser());
            $em->persist($advice);
            $em->flush();

            return $this->redirectToRoute('shout_show', ['slug' => $shout->getSlug()]);
        }

        $advices = $em->getRepository('AppBundle:Advice')
            ->findBy(
                ['shout' => $shout],
                ['createdAt' => "DESC"],
                5
            );

        dump($advices);

        return $this->render('shout/show.html.twig', [
            'shout' => $shout,
            'advices' => $advices,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{slug}/delete", name="shout_delete")
     */
    public function deleteAction(Shout $shout)
    {
        // add token validation here

        $em = $this->getDoctrine()->getManager();
        $em->remove($shout);
        $em->flush();

        return new Response("deleted");
    }
}
