<?php

namespace Mailer;

use Mailer\Contracts\Contact as ContactInterface;

class Contact implements ContactInterface
{
    protected $email = null;
    protected $name  = null;

    public function __construct($email, $name = null)
    {
        $this->email = $email;
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }
}
