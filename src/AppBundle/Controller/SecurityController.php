<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function forgotPasswordAction()
    {
        
        return $this->render('security/forgot_pass.html.twig');
    }
}
