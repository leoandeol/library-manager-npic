<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction(Request $request)
    {
        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
		*/
		return $this->render($this->generateUrl('default/index.html.twig'));
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
}
