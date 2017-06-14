<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home", options={"expose"=true})
     */
    public function homeAction(Request $request)
    {
        $locale = $this->get('translator')->getLocale();

		$rep = $this->getDoctrine()->getManager()->getRepository('AppBundle:Item');
		$top = $rep->findTop5PopularBooks();
		$last = $rep->findLast5BooksAdded();
		$pop = $rep->find5MostPopularBooks();

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
        return $this->render('default/howto.html.twig');
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

    /**
     * @Route("/highwaytonowhere/{password}", name="checktransactions")
     */
    public function CheckStateOfTransactionsAction(Request $request,$password)
    {
        if($password == "20041808"){
			$mailer		= $this->get('my.mailer');
			$em		    = $this->getDoctrine()->getManager();
			$lib_rep  	= $em->getRepository('AppBundle:Librarian');
			$memb_rep 	= $em->getRepository('AppBundle:Member');
			$trans_rep	= $em->getRepository('AppBundle:Transaction');
			$librarians = $lib_rep->findAll();
            $members 	= $memb_rep->findAll();
			
			foreach($members as $member){			
				$today 		  = new \DateTime(date('Y-m-d'));
				$memb_mail    = $member->getEmail();
				$transactions = $trans_rep->findBy(array('member'=>$member));
				foreach($transactions as $transac){
					$id 	  = $transac->getId();
					$toReturn = $transac->getToReturnDate();
					$state	  = $transac->getState();
					if($today < $toReturn && $state == 'Borrowed'){
						$dif  = $toReturn->diff($today)->days;
						if($dif <= 3){
							$mailer->sendTemplateMessage($memb_mail,"NPIC Library return reminder","email/reminderToReturn.html.twig",
							array('trans_id' => $id, 'days' => $dif,'date' => $toReturn));	
						}
					}else if($today > $toReturn && $state == 'Borrowed'){
						$dif  = $today->diff($toReturn)->days;
						$fcdp = $transac->getFineCostPerDay();
						$toPay= $dif * $fcdp;
						$transac->setFineToPay($toPay);
						$mailer->sendTemplateMessage($memb_mail,"NPIC Library return reminder","email/reminderToReturnAndPay.html.twig",
						array('trans_id' => $id, 'days' => $dif,'fcpd' => $toReturn,'toPay' => $toPay));
						foreach($librarians as $librarian){
							$mailer->sendTemplateMessage($librarian->getEmail(),"NPIC Library transaction ended","email/reminderTransactionEnded.html.twig",
							array('trans_id' => $id,'memb_id' => $member->getCode(), 'days' => $dif,'toPay' => $toPay));
						}
					}
				}
			}
            return new Response('OK');
        }
        else {
            return new Response('Access Denied');	
        }
    }


}
