<?php
    //use Silex\Application;
    //use Silex\Provider\TwigServiceProvider;

class TwigMailGenerator //extends \Twig_Environment
{
    public $subject = 'Notificação básicas';
    public $from    = 'Meu e-Mail <dev@everlon.com.br>';
    public $to;
    public $cc;
    public $bcc;
    public $replyto = 'Meu e-Mail <dev@everlon.com.br>';
    public $html;

    public function send() {
        $headers  = "From: ".$this->from. PHP_EOL;
        $headers .= "Reply-To: ".$this->replyto. PHP_EOL;
        $headers .= "Return-Path:  ".$this->from. PHP_EOL;
        $headers .= "X-Mailer: PHP/".phpversion(). PHP_EOL;
        $headers .= 'Content-type: text/html; charset=ISO-8859-1'. PHP_EOL;
        $headers .= "Content-Transfer-Encoding: 7bit". PHP_EOL;
        $headers .= "CC: ".$this->cc. PHP_EOL;
        $headers .= "BCC: ".$this->bcc. PHP_EOL;

        return mail($this->to, $this->subject, $this->html, $headers);
    }
}