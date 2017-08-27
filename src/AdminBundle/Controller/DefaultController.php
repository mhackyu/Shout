<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function indexAction()
    {
//        dump("Asd");die;
        return $this->render('AdminBundle:Default:index.html.twig');
    }
}
