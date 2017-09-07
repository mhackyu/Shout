<?php

namespace AppBundle\Controller;

use AppBundle\Service\TopShouts;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TopController
 * Controller used to manage top shouts within specific date.
 * @author Mark Christian E. Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class TopController extends Controller
{
    /**
     * @Route("/top-shouts/")
     */
    public function topShoutsAction()
    {
        $em = $this->getDoctrine()->getManager();
        // This service will get all top shouts.
        $topShouts = new TopShouts($em);
        $top10 = $topShouts->getTopShouts($topShouts::$WEEK);

        return $this->render('topShouts/list.html.twig', [
            'topShouts' => $top10
        ]);
    }
}
