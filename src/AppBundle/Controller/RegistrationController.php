<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Utils\TokenGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationController
 * Controller used to manage the registration of the user
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     */
    public function registerAction(Request $request, TokenGenerator $tokenGenerator)
    {
        // Prevent user to visit registration page if already logged in
        $authChecker = $this->get('security.authorization_checker');
        if ($authChecker->isGranted("ROLE_USER")) {
            return $this->redirectToRoute('shout_list');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
//        $form->remove('avatar');
//        $form->remove('about');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode plain password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRole("ROLE_USER");
            $user->setConfirmationToken($tokenGenerator->generateConfirmationToken());
            $user->setAvatar(strtolower($user->getGender()) . ".png");

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('registration_check_email', ['u' => $user->getUsername()]);
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/check-email", name="registration_check_email")
     */
    public function checkEmailAction(Request $request, \Swift_Mailer $mailer, TokenGenerator $tokenGenerator)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')
            ->findOneBy(['username' => $request->get('u')]);

        // This will check if the account is existing.
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        // If already confirmed, redirect to login page.
        if ($user->isEnabled()) {
            $this->addFlash('info', 'Account is already activated');
            return $this->redirectToRoute('login');
        }

        // Send email confirmation to email of the user.
        $email = $user->getEmail();

        $message = (new \Swift_Message('Welcome to Shout!'))
            ->setFrom('contactshoutee@gmail.com','Team Shout')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig', [
                    'name' => $user->getFirstName(),
                    'token' => $user->getConfirmationToken()
                ]),
                'text/html'
            );

        $mailer->send($message);

        return $this->render('registration/check_email.html.twig', [
            'email' => $email,
            'username' => $user->getUsername()
        ]);
    }

    /**
     * @Route("/confirm/{confirmationToken}", name="registration_confirm")
     */
    public function confirmAction(User $user)
    {
        // This will check if the account is existing.
        if (!$user) {
            $this->addFlash('danger', 'Failed to confirm.');
            return $this->redirectToRoute('login');
        }

        // Activate user.
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(true);
        $em->flush();
        $this->addFlash('success', 'Successfully registered!');

        return $this->redirectToRoute('login');
    }

}
