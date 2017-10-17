<?php

namespace AdminBundle\Controller;

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
 * @package AdminBundle\Controller
 */

class ProfileController extends Controller
{
    /**
     * @Route("admin/profile", name="admin_profile")
     */

    public function profileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            $user->setPlainPassword($form->get('oldPlainPassword')->getData());
            dump($user);
            if ($form->isSubmitted() && $form->isValid()) {
//                $encodedPass = $this->get('security.password_encoder')
//                    ->encodePassword($user, $user->getPlainPassword());
//                $user->setPassword($encodedPass);
//            $em->flush();
                $this->addFlash("success", "Your profile was successfully updated.");

                return $this->redirectToRoute('my_profile_show');
            }
            else {
                $this->addFlash("danger", "Failed to update your profile.");
            }
        }

        return $this->render('AdminBundle:profile:profile_settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
     
     /**
     * @Route("admin/security", name="change_password")
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

                return $this->redirectToRoute('change_password');
            }
            else {
                $this->addFlash("danger", "Failed to update to update password.");
            }
        }

        return $this->render('AdminBundle:security:change_pass.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
