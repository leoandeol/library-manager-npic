<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{

    /**
     * @Route("/book/list/{page}", name="booklist", requirements={"page": "\d+"})
     */
    public function readAll(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('book/readAll.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
