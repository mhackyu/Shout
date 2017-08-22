<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Love;
use AppBundle\Entity\Shout;
use AppBundle\Form\ShoutType;
use AppBundle\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ShoutController
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
//        dump($this->getUser());
        $em = $this->getDoctrine()->getManager();
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
     */
    public function showAction(Shout $shout)
    {
        dump($shout);die;
    }

    /**
     * @Route("/love/{slug}")
     */
    public function loveAction(Shout $shout)
    {
//        dump($this->get('app.twig.isLove_extension')->isLoveFilter($this->getUser(), $shout));die;
//        $love = new Love();
//        $love->setShout($shout);
//        $love->setUser($this->getUser());
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($love);
//        $em->flush();
        dump($shout->getLove()[0]);die;
    }
}
