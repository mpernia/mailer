<?php

namespace Mailer\Contracts;

use Mailer\Contracts\Transport;
use Mailer\Contracts\Message;

interface Mailer
{
    const DELIVERED = 200;
    const FAILED    = 400;
    const SEND      = 202;

    public function __construct(Message $message, Transport $transport);

    public function to();

    public function email();

    public function from();

    public function send();

    public function errorMessage();
}
