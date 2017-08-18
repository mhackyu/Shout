<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShoutController extends Controller
{

    /**
     * @Route("/shouts", name="shout_list")
     */
    public function listAction()
    {
        return $this->render('shout/list.html.twig');
    }
}
