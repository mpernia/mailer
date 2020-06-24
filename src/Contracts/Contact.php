<?php

namespace Mailer\Contracts;

interface Contact
{
    public function __construct($email, $name = null);

    public function name();

    public function email();
}
