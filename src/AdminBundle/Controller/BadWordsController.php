<?php
namespace AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BadWords;
use AppBundle\Form\BadWordsType;
use Symfony\Component\HttpFoundation\Request;

class BadWordsController extends Controller
{
    /**
     * @Route("admin/badwords", name="admin_badwords_list")
     */
    public function listAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$badword = $em->getRepository('AppBundle:BadWords')->findAll();
        return $this->render('AdminBundle:badwords:list.html.twig', [
        	'badword' => $badword
        ]);
    }

    /**
     * @Route("admin/badwords/new", name="admin_badwords_new")
     */
    public function newAction(Request $request)
    {
        $badwords = new BadWords();
        $form = $this->createForm(BadWordsType::class, $badwords);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($badwords);
            $em->flush();
            return $this->redirectToRoute('admin_badwords_list');
        }
        return $this->render('AdminBundle:badwords:new.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/badwords/{id}/edit", name="admin_badwords_edit")
     */

    public function editAction(BadWords $badwords, Request $request)
    {
        $form = $this->createForm(BadWordsType::class, $badwords);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_badwords_list');
        }
        return $this->render('AdminBundle:badwords:edit.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/badwords/{id}/delete", name="admin_badwords_delete")
     */
    
    public function deleteAction(BadWords $badwords, Request $request)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($badwords);
            $em->flush();
            return $this->redirectToRoute('admin_badwords_list');
        
    }  
}
