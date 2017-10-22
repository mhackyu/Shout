<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\PasswordResetType;
use AppBundle\Utils\TokenGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * Controller used to handle the security of the site.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // Prevent user to visit log in page if already logged in
        $authChecker = $this->get('security.authorization_checker');
        if ($authChecker->isGranted("ROLE_USER")) {
           return $this->redirectToRoute('shout_list');
        }

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/redirect", name="redirect")
     */
    public function redirectAction()
    {
        if ($this->getUser()->getRoles()[0] == "ROLE_USER") {
            return $this->redirectToRoute('shout_list');
        }
        else if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            return $this->redirectToRoute('admin_index');
        }

//        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/forgot-password", name="forgot_password")
     */
    public function forgotPasswordAction(Request $request, \Swift_Mailer $mailer, TokenGenerator $tokenGenerator)
    {
        $email = $request->request->get('email');
        $token = $request->request->get('token');

        if ($request->isMethod("POST")) {
            // This will check if the token is valid
            if (!$this->isCsrfTokenValid('forgotPass', $token)) {
                return $this->redirectToRoute("forgot_password");
            }

            // Check if the account is existing
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')
                ->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('danger', 'Account is not existing.');
                return $this->redirectToRoute("forgot_password");
            }

            // Generate password reset token
            $user->setPasswordResetToken($tokenGenerator->generatePasswordResetToken());
            $em->flush();

            // Send password link to email
            $message = (new \Swift_Message("Reset Password"))
                ->setFrom($this->getParameter('app.sender_email'), $this->getParameter('app.sender_name'))
                ->setTo($email)
                ->setBody(
                    $this->render(
                        'emails/forgot_pass.html.twig', ['name' => $user->getFirstName(), 'token' => $user->getPasswordResetToken()]),
                    'text/html'
                );

            $mailer->send($message);
            $this->addFlash('success', 'Password Reset link was sent to your email.');

            return $this->render('security/forgot_pass_sent.html.twig');
        }

        return $this->render('security/forgot_pass.html.twig');
    }

    /**
     * @Route("/reset-password/{passwordResetToken}", name="password_reset")
     */
    public function confirmPasswordReset(User $user, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $avatarFilename = $user->getAvatar();
        $user->setAvatar($this->getParameter('app.avatar_dir') . "/" . $avatarFilename);
        $form = $this->createForm(PasswordResetType::class, $user);
//        $form->remove('avatar');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPass = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encodedPass);
            $user->setAvatar($avatarFilename);
            $user->setPasswordResetToken("");
            $em->flush();
            $this->addFlash("success", "Password successfully reset.");

            return $this->redirectToRoute('login');
        }

        return $this->render('security/reset_pass.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
