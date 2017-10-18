<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserReview;
use AppBundle\Form\ChangePasswordFormType;
use AppBundle\Form\ProfileFormType;
use AppBundle\Form\UserReviewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProfileController
 * Controller used to manage the profile of the user.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class ProfileController extends Controller
{
    /**
     * @Route("/user/{username}", name="profile_show")
     */
    public function userAction(Request $request, User $user)
    {
        if ($user->getId() == $this->getUser()->getId()) {
            return $this->redirectToRoute('profile_me');
        }

        $userReview = new UserReview();
        $em = $this->getDoctrine()->getManager();
        $reviews = $em->getRepository('AppBundle:User')
            ->find($user->getId())->getUserReview();

        $form = $this->createForm(UserReviewType::class, $userReview);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $userReview->setUser($user);
                $userReview->setReviewedBy($this->getUser());
                $em->persist($userReview);
                $em->flush();

                return $this->redirectToRoute('profile_show', ['username' => $user->getUsername()]);
            }
        }

        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'reviews' => $reviews,
            'me' => false,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/me", name="profile_me")
     */
    public function meAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $reviews = $em->getRepository('AppBundle:User')
            ->find($user->getId())->getUserReview();

        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'reviews' => $reviews,
            'me' => true
        ]);
    }

    /**
     * @Route("/profile", name="my_profile_show")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        // In-add ko lang to kasi vinavalidate nya na dapat ndi empty si plainpassword.
        $user->setPlainPassword("dummy-data");
        $form = $this->createForm(ProfileFormType::class, $user);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash("success", "Your profile was successfully updated.");

                return $this->redirectToRoute('profile_me');
            }
            else {
                $this->addFlash("danger", "Failed to update your profile.");
            }
        }

        return $this->render('profile/profile_settings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/change-password", name="user_change_password")
     */
    public function changePassAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $encodedPass = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encodedPass);
                $em->flush();
                $this->addFlash("success", "Password successfully changed.");

                return $this->redirectToRoute('shout_list');
            }
            else {
                $this->addFlash("danger", "Failed to update to update password.");
            }
        }

        return $this->render('security/change_pass.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
