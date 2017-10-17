<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserReview;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/review/{id}/delete", name="review_delete")
     */
    public function deleteAction(Request $request, UserReview $userReview)
    {
        $em = $this->getDoctrine()->getManager();

        // Check the owner of the review.
        if ($this->getUser() !== $userReview->getReviewedBy()) {
            return $this->redirectToRoute('profile_show', ['username' =>  $request->request->get('username')]);
        }

        // Check if the token is valid.
        if (!$this->isCsrfTokenValid('deleteReview', $request->request->get('_token'))) {
            return $this->redirectToRoute('profile_show', ['username' =>  $request->request->get('username')]);
        }

        $em->remove($userReview);
        $em->flush();

        return $this->redirectToRoute('profile_show', ['username' =>  $request->request->get('username')]);
    }
}
