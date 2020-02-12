<?php

namespace App\Services;


use Twig\Environment;


class Mailing
{
    private $mailer;
    private $twig;


    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMail($userMail)
    {
        $message = (new \Swift_Message())
            ->setFrom('d.delima@outlook.fr')
            ->setTo($userMail)
            ->setBody($this->twig->render('Frontend/Ticketing/email.html.twig'), 'text/html');



        $this->mailer->send($message);
        return true;
    }

}