<?php

namespace Mailer\Transports;

use Dotenv\Dotenv;

use Mailer\Contracts\Transport as TransportInterface;

abstract class Transport implements TransportInterface
{
    protected $smtp_username  = null;
    protected $smtp_password  = null;
    protected $smtp_host      = null;
    protected $smtp_port      = null;
    protected $custom_headers = null;
    const SMTP_AUTH           = true;
    const SMTP_SECURITY       = 'tls';


    public function __construct($username = '', $password = '', $host = '', $port = '')
    {
        $dotenv;
        $dotenv = Dotenv::create( __DIR__ . "/../../../../../" );
        $dotenv->overload();
        $dotenv->required(['SMTP_HOST', 'SMTP_PORT', 'SMTP_USER', 'SMTP_PASS', 'SENDER_NAME', 'SENDER_ADDRESS'])->notEmpty();

        $this->smtp_username = empty($smtp_username) ? $_ENV['SMTP_USER'] : $smtp_username;

        $this->smtp_password = empty($smtp_password) ? $_ENV['SMTP_PASS'] : $smtp_password;

        $this->smtp_host     = empty($host)          ? $_ENV['SMTP_HOST'] : $host;

        $this->smtp_port     = empty($port)          ? $_ENV['SMTP_PORT'] : $port;
    }

    public function setUsername($username)
    {
        $this->smtp_username = $username;

        return $this;
    }

    public function setPassword($password)
    {
        $this->smtp_password = $password;

        return $this;
    }

    public function setHost($host)
    {
        $this->smtp_host = $host;

        return $this;
    }

    public function setPort($port)
    {
        $this->smtp_port = $port;

        return $this;
    }

    public function addCustomHeader($key, $value)
    {
        $this->custom_headers[] = ['key' => $key, 'value' => $value];

        return $this;
    }

    public function username()
    {
        return $this->smtp_username;
    }

    public function password()
    {
        return $this->smtp_password;
    }

    public function host()
    {
        return $this->smtp_host;
    }

    public function port()
    {
        return $this->smtp_port;
    }

    public function auth()
    {
        return self::SMTP_AUTH;
    }

    public function security()
    {
        return self::SMTP_SECURITY;
    }

    public function customHeaders()
    {
        return $this->custom_headers;
    }
}
