<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Quote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuoteController
 * Controller used to manage quotes.
 * @author Mark Christian E. Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Controller
 */
class QuoteController extends Controller
{
    /**
     * @Route("/quotes", name="quote_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $category = $em->getRepository('AppBundle:QuoteCategory')->find(1);
//        $quote = new Quote();
//        $quote->setContent("Lorem lorem sinta");
//        $quote->setQuoteBy("mhackyu");
//        $quote->setCategory($category);
//
//        $em->persist($quote);
//        $em->flush();

        $quotes = $em->getRepository('AppBundle:Quote')
            ->findAll();

        dump($quotes);die;
    }

    /**
     * Cron job for quote of the day.
     * @Route("/quote-of-the-day", name="quote_of_the_day")
     */
    public function quoteOfTheDayAction()
    {
        //TODO: CREATE A SERVICE THAT WILL GENERATE QUOTE OF THE DAY
        $em = $this->getDoctrine()->getManager();
        $quotes = $em->getRepository('AppBundle:Quote')
            ->findBy([
                'isPublished' => false,
                'isQuoteOfTheDay' => false
            ]);

        // reset quote of the day.
        $em->getRepository('AppBundle:Quote')
            ->resetQuoteOfTheDay();

        if (empty($quotes)) {
            return new Response("No quotes available.");
        }

        // This will generate random number (w/c is index) from array of quotes.
        // This will also generate the quote of the day.
        $randIndex = array_rand($quotes);
        $quotes[$randIndex]->setIsPublished(true);
        $quotes[$randIndex]->setIsQuoteOfTheDay(true);
        $em->flush();
        dump($quotes[$randIndex]);die;
    }
}
