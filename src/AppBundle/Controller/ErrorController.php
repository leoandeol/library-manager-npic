<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Member;
use AppBundle\Entity\Student;
use AppBundle\Entity\Staff;
use AppBundle\Entity\Librarian;
use AppBundle\Entity\Address;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime; 

class ErrorController extends Controller
{
						
	/**
     * @Route("/error", name="error")
     */
    public function errorAction(Request $request)
    {
        return $this->render('default/error.html.twig',	[
			'error' => $request->get('error'),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
     * @Route("/error/WrongPassword", name="errorWrongPassword")
     */
    public function errorWrongPasswordAction(Request $request)
    {
		$error = "The password given is wrong.";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

	/**
     * @Route("/error/NotAdmin", name="errorNotAdmin")
     */
    public function errorNotAdminAction(Request $request)
    {
		$error = "You are not allowed to do this.";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

	/**
     * @Route("/error/NotExistingUser", name="errorNotExistingUser")
     */
    public function errorNotExistingUserAction(Request $request)
    {
		$error = "This user doesn't exist.";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

	/**
     * @Route("/error/NotLogged", name="errorNotLogged")
     */
    public function errorNotLoggedAction(Request $request)
    {
		$error = "you must log in to do this.";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

	/**
     * @Route("/error/DisabledUser", name="errorDisabledUser")
     */
    public function errorDisabledUserAction(Request $request)
    {
		$error = "This user is disabled";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
     * @Route("/error/DisabledItem", name="errorDisabledItem")
     */
    public function errorDisableditemAction(Request $request)
    {
		$error = "This item is disabled";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
	
	/**
     * @Route("/error/NotExistingItem", name="errorNotExistingItem")
     */
    public function errorNotExistingItemAction(Request $request)
    {
		$error = "This item doesn't exist.";
        return $this->render('default/error.html.twig',	[
			'error' => $error,
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}

?>