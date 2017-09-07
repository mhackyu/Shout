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
     * @Route("/advice/{id}/helpful", name="advice_helpful")
     */
    public function foundHelpfulAction(Advice $advice)
    {
        $helpful = new FoundHelpful();
        $helpful->setAdvice($advice);
        $helpful->setUser($this->getUser());

//        $advice->setFoundHelpful($helpful);

        $em = $this->getDoctrine()->getManager();
        $em->persist($helpful);
        $em->flush();

        dump($advice);die;

    }

}
