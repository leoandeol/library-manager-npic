<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home", options={"expose"=true})
     */
    public function homeAction(Request $request)
    {
        $locale = $this->get('translator')->getLocale();
	//var_dump($locale);
	$rep = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
	$top = $rep->findTop5PopularBooks();
	$last = $rep->findLast5BooksAdded();
	$pop = $rep->find5MostPopularBooks();
	// replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
			"tops" => $top,
			"lasts" => $last,
			"pops" =>$pop,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/howto", name="howto")
     */
    public function howToAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/howto.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/about.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

/**
 * Change the locale for the current user
 *
 * @param String $language
 * @return array
 *
 * @Route("/setlocale/{language}", name="setlocale")
 */
public function setLocaleAction(Request $request, $language = null)
{
    if($language != null)
    {
        // On enregistre la langue en session
        $this->get('session')->set('_locale', $language);
	}
 
    // on tente de rediriger vers la page d'origine
    $url = $request->headers->get('referer');
    if(empty($url))
    {
        $url = $this->generateUrl('home');
    }
 
    return $this->redirect($url);;
}
}
