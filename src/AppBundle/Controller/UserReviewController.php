<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserReview;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserReviewController extends Controller
{
    /**
     * @Route("/reviews" , name="review_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $userReview = new UserReview();
//        $user = $em->getRepository('AppBundle:User')->find(4);
//        $userReview->setUser($this->getUser());
//        $userReview->setReview("WOW!");
//        $userReview->setReviewedBy($user);
//
//        $em->persist($userReview);
//        $em->flush();

//        die;
//        $reviews = $em->getRepository('AppBundle:UserReview')
//            ->findAll();
        $reviews = $em->getRepository('AppBundle:User')->find(1);
        dump($reviews->getUserReview()[1]);die;
    }
}
