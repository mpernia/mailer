<?php

namespace Mailer;

use Mailer\Contracts\Message as MessageInterface;

class Message implements MessageInterface
{
    protected $address     = null;
    protected $subject     = null;
    protected $body        = null;
    protected $attachments = null;
    protected $params      = null;

    function __construct($address, $subject, $body, $params = [], $attachments = [])
    {
        $this->address     = $address;
        $this->subject     = $subject;
        $this->params      = $params;
        $this->body        = $this->renderBody($body);
        $this->attachments = $attachments;
    }

    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function address()
    {
        return $this->address;
    }

    public function subject()
    {
        return $this->subject;
    }

    public function body()
    {
        return $this->body;
    }

    public function attachments()
    {
        return $this->attachments;
    }

    private function renderBody($body)
    {
        $mustache = new \Mustache_Engine;

        return $mustache->render($body, $this->params);
    }
}
