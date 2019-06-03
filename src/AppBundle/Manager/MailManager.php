<?php

namespace AppBundle\Manager;

class MailManager
{
    protected $mailer;
    protected $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * Send email
     *
     * @param   string   $template      email template
     * @param   mixed    $parameters    custom params for template
     * @param   mixed    $to            to email address or array of email addresses
     * @param   string   $from          from email address
     * @param   string   $fromName      from name
     *
     * @return  boolean                 send status
     */
    public function sendEmail($template, $parameters, $to, $from, $fromName = null)
    {
        $template = $this->twig->loadTemplate('AppBundle:Mails:' . $template . '.html.twig');

        $subject  = $template->renderBlock('subject', $parameters);
        $bodyHtml = $template->renderBlock('body_html', $parameters);

        try {
            $message = \Swift_Message::newInstance()
                                     ->setSubject($subject)
                                     ->setFrom($from, $fromName)
                                     ->setTo($to)
                                     ->setBody($bodyHtml, 'text/html')
            ;
            $response = $this->mailer->send($message);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        return $response;
    }
}
