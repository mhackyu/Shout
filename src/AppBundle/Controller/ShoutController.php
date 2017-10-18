<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advice;
use AppBundle\Entity\Shout;
use AppBundle\Form\AdviceFormType;
use AppBundle\Form\ShoutType;
use AppBundle\Utils\Slugger;
use mofodojodino\ProfanityFilter\Check;
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

        if ($request->get('type')) {
            $shouts = $em->getRepository('AppBundle:Shout')->shoutsByCategoryDQL($request->get('type'));
        }
        else {
            $shouts = $em->getRepository('AppBundle:Shout')->shoutsDQL();
        }

        $categories = $em->getRepository('AppBundle:ShoutCategory')->findAllASC();
        $paginator = $this->get('knp_paginator');
        $results = $paginator->paginate(
            $shouts,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );
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
            'shouts' => $results,
            'categories' => $categories,
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
            $shout->setSlug($slugger->slugify($shout->getTitle()));
            $shout->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($shout);
            $em->flush();
            $this->addFlash('success', "Shout successful");

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
        if ($this->get('session')->has('adv')) {
            $advice->setContent($this->get('session')->get('adv'));
        }
        $form = $this->createForm(AdviceFormType::class, $advice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // TODO: create a service for profanity filter.
            // Profanity filter for advice.
            // This will get all badwords from database.
            $badWords = $em->getRepository('AppBundle:BadWords')
                ->getAllBadWords();
            $check = new Check($badWords);
            $hasProfanity = $check->hasProfanity($advice->getContent());
            if ($hasProfanity) {
                $this->addFlash('danger', "Your advice contains bad words that can hurt and offend the shoutee. Please be mindful to the feelings of your fellow shoutee.");
                $this->get('session')->set('adv', $advice->getContent());
                return $this->redirectToRoute('shout_show', ['slug' => $shout->getSlug()]);
            }

            // Post advice if no bad words encountered.
            $advice->setShout($shout);
            $advice->setUser($this->getUser());
            $em->persist($advice);
            $em->flush();

            // Remove 'adv' session if advice is posted.
            if ($this->get('session')->has('adv')) {
                $this->get('session')->remove('adv');
            }
            $this->addFlash('success', "Advice successfully posted.");

            return $this->redirectToRoute('shout_show', ['slug' => $shout->getSlug()]);
        }

        // This will check if the current user is the owner of the shout.
        $isOwner = false;
        if ($shout->getUser() == $this->getUser()) {
            $isOwner = true;
        }

        // Get all advices from shout.
        $advices = $em->getRepository('AppBundle:Advice')->findAllDQL($shout->getId());
        $paginator = $this->get('knp_paginator');
        $results = $paginator->paginate(
            $advices,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('shout/show.html.twig', [
            'shout' => $shout,
            'advices' => $results,
            'form' => $form->createView(),
            'isOwner' => $isOwner
        ]);
    }

    /**
     * @Route("/{slug}/delete", name="shout_delete")
     */
    public function deleteAction(Request $request, Shout $shout)
    {
        if (!$this->isCsrfTokenValid('delete', $request->get('token'))) {
            $this->addFlash('danger', 'Failed to delete shout. Invalid token.');
            return $this->redirect($request->get('next'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($shout);
        $em->flush();
        $this->addFlash('success', 'Successfully deleted.');

        return $this->redirect($request->get('next'));
    }

    /**
     * @Route("/{slug}/edit", name="shout_edit")
     */
    public function editAction(Shout $shout, Request $request)
    {
        // Redirect to shout list if he/she is not the owner of the shout.
        if ($shout->getUser() != $this->getUser()) {
            return $this->redirectToRoute('my_shout_list');
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ShoutType::class, $shout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shout->setUpdatedAt(new \DateTime());
            $em->flush();
            $this->addFlash('success', "Successfully updated.");

            return $this->redirectToRoute('my_shout_list');
        }

        return $this->render('shout/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
