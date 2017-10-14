<?php
namespace AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Quote;
use AppBundle\Form\QuoteType;
use AppBundle\Entity\QuoteCategory;
use AppBundle\Form\QuoteCategoryType;
use Symfony\Component\HttpFoundation\Request;

class QuotesController extends Controller
{
    /**
     * @Route("admin/quotes", name="admin_quotes_list")
     */
    public function listAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $quotes = $em->getRepository('AppBundle:Quote')->findQuoteByContent($request->get('search'));
    	//$quotes = $em->getRepository('AppBundle:Quote')->findAll();
        return $this->render('AdminBundle:quotes:list.html.twig', [
        	'quotes' => $quotes , 
            'search' => $request->get('search')
        ]);
    }


    /**
     * @Route("admin/quotes/new", name="admin_quotes_new")
     */
    public function newAction(Request $request)
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();
            return $this->redirectToRoute('admin_quotes_list');
        }
        return $this->render('AdminBundle:quotes:new.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/quotes/{id}/edit", name="admin_quotes_edit")
     */

    public function editAction(Quote $quote, Request $request)
    {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_quotes_list');
        }
        return $this->render('AdminBundle:quotes:edit.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/quotes/{id}/delete", name="admin_quotes_delete")
     */
    
    public function deleteAction(Quote $quote, Request $request)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($quote);
            $em->flush();
            return $this->redirectToRoute('admin_quotes_list');
        
    }    

     /**
     * @Route("admin/quotecatg", name="admin_quotecatg_list")
     */
    public function listquoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quote_category = $em->getRepository('AppBundle:Quote')->findQuoteByCategoryName($request->get('search'));
        return $this->render('AdminBundle:quotes:quotecatg.html.twig', [
            'quote_category' => $quote_category,
            'search' => $request->get('search')
        ]);
    }

     /**
     * @Route("admin/quotecatg/new", name="admin_quotecatg_new")
     */
    public function newquoteAction(Request $request)
    {
        $quote = new QuoteCategory();
        $form = $this->createForm(QuoteCategoryType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();
            return $this->redirectToRoute('admin_quotecatg_list');
        }
        return $this->render('AdminBundle:quotes:quotenew.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/quotecatg/{id}/delete", name="admin_quotecatg_delete")
     */
    
    public function deletequoteAction(QuoteCategory $quotecatg, Request $request)
    {
        //TODO: soft deletable
            $em = $this->getDoctrine()->getManager();
            $em->remove($quotecatg);
            $em->flush();
            return $this->redirectToRoute('admin_quotecatg_list');       
    }    

     /**
     * @Route("admin/quotecatg/{id}/edit", name="admin_quotecatg_edit")
     */

    public function editquoteAction(QuoteCategory $quotecatg, Request $request)
    {
        $form = $this->createForm(QuoteCategoryType::class, $quotecatg);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_quotecatg_list');
        }
        return $this->render('AdminBundle:quotes:quoteedit.html.twig', [
                'form'=> $form->createView()
            ]);
    }

     /**
     * @Route("admin/search", name="admin_quotes_search")
     */
    public function searchquoteAction()
     {

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Quote')->findQuoteByContent("love");
        dump($results);die;

        if ($request->isMethod("GET")) {
            $search = $request->get('search');
            if ($search) {
                $results = $em->getRepository('AppBundle:Quote')->findQuoteByContent($search);
               
                return $this->render('AdminBundle:quotes:list.html.twig', [
                'search'=> $search
            ]);
            }
            }
        }
}
