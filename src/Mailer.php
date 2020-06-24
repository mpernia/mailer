<?php

namespace Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Mailer\Contracts\Message;
use Mailer\Contracts\Transport;
use Mailer\Contracts\Mailer as MailerInterface;

class Mailer implements MailerInterface
{
    protected $message   = null;
    protected $transport = null;
    protected $mail      = null;
    protected $is_html   = null;

    public function __construct(Message $message, Transport $transport, $is_html = true)
    {
        $this->message   = $message;
        $this->transport = $transport;
        $this->is_html   = $is_html;
    }

    public function to()
    {
        return [
            'address' => $this->message->address()->email(),
            'name'    => $this->message->address()->name()
        ];
    }

    public function email()
    {
        return $this->message->body();
    }

    public function from()
    {
        return [
            'address' => $_ENV['SENDER_NAME'],
            'name'    => $_ENV['SENDER_ADDRESS']
        ];
    }

    public function send()
    {
        $this->config();

        try {

            $this->mail->Send();

            return  true;

        } catch (phpmailerException $e) {

            $this->error = 'An error occurred. ' . $e->errorMessage();

        } catch (Exception $e) {

            $this->error = 'Email not sent. ' . $this->mail->ErrorInfo;

        }

        return false;
    }

    public function errorMessage()
    {
        return $this->error;
    }

    private function config()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->isHTML($this->is_html);
        $this->mail->setFrom($_ENV['SENDER_ADDRESS'], $_ENV['SENDER_NAME']);
        $this->mail->addAddress($this->message->address()->email(), $this->message->address()->name());

        $this->mail->Username   = $this->transport->username();
        $this->mail->Password   = $this->transport->password();
        $this->mail->Host       = $this->transport->host();
        $this->mail->Port       = $this->transport->port();
        $this->mail->SMTPAuth   = $this->transport->auth();
        $this->mail->SMTPSecure = $this->transport->security();
        $this->mail->Subject    = $this->message->subject();
        $this->mail->Body       = $this->message->body();
        $this->mail->AltBody    = strip_tags($this->message->body());

        foreach ($this->message->attachments() as $attachment){
            $this->mail->addAttachment($attachment);
        }

        foreach ($this->transport->customHeaders() as $custom_header) {
            $this->mail->addCustomHeader($custom_header['key'], $custom_header['value']);
        }

    }
}
