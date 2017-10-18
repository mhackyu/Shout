<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    /**
     * @Route("/notification-overview", name="notification_overview")
     */
    public function notificationOverviewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('AppBundle:Notification')->findBy(
            [
                'user' => $this->getUser()
            ],
            [
                'createdAt' => "DESC"
            ],
            5
        );

        return $this->render('notifications/overview.html.twig', [
            'notifications' => $notifications,
            'notication_count' => count($notifications)
        ]);
    }

    /**
     * @Route("/notification/{id}/seen", name="notification_seen")
     */
    public function seenAction(Notification $notification)
    {
        $notification->setSeen(true);
        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirect($notification->getLink());
    }

    /**
     * @Route("/notifications", name="notification_list")
     */
    public function listAction()
    {
        $notifications = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Notification')
            ->findAll();

        dump($notifications);die;

        return $this->render('notifications/show.html.twig', [
            'notifications' => $notifications
        ]);
    }

//    /**
//     * @Route("/notification/seen-all", name="notification_seen_all")
//     */
//    public function seenAllAction()
//    {
//        $this->getDoctrine()->getManager()
//            ->getRepository('AppBundle:Notification')
//            ->markAllAsSeen($this->getUser()->getId());
//    }
}
