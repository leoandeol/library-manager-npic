<?php

namespace AppBundle\Listener;

use Symfony\Component\Templating\EngineInterface;

class MailService
{
protected $mailer;
protected $templating;
private $from = "lib-autorespond@npic.edu.kh";
private $reply = "lib-autorespond@npic.edu.kh";
private $name = "Library bot - do not reply";

public function __construct($mailer, EngineInterface $templating)
{
$this->mailer = $mailer;
$this->templating = $templating;
}

public function sendMessage($to, $subject, $body)
{
$mail = \Swift_Message::newInstance();

$mail->setFrom($this->from,$this->name)
->setTo($to)
->setSubject($subject)
->setBody($body)
->setReplyTo($this->reply,$this->name)
->setContentType("text/html");

$this->mailer->send($mail);
}

public function sendTemplateMessage($to, $subject, $path, $array = array())
{
$mail = \Swift_Message::newInstance();

$mail->setFrom($this->from,$this->name)
->setTo($to)
->setSubject($subject)
->setBody(
            $this->renderView(
                $path,
		$array
            ),
            'text/html')
->setReplyTo($this->reply,$this->name)
->setContentType("text/html");

$this->mailer->send($mail);
}

}
?>