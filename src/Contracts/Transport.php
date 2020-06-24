<?php

namespace Mailer\Contracts;

interface Transport
{
    public function __construct($username = '', $password = '', $host = '', $port = '');

    public function setUsername($username);

    public function setPassword($password);

    public function setHost($host);

    public function setPort($port);

    public function addCustomHeader($key, $value);

    public function username();

    public function password();

    public function host();

    public function port();

    public function auth();

    public function security();

    public function customHeaders();
}
