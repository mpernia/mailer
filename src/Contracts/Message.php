<?php

namespace Mailer\Contracts;

interface Message
{
    public function __construct($address, $subject, $body, $params = [], $attachments = []);

    public function setAttachments($attachments);

    public function address();

    public function subject();

    public function body();

    public function attachments();
}
