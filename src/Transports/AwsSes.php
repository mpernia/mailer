<?php

namespace Mailer\Transports;

use Mailer\Transports\Transport as TransportBase;

class AwsSes extends TransportBase
{
    public function  __construct($username = '', $password = '', $host = '', $port = '')
    {
        parent::__construct();

        $this->addCustomHeader('X-SES-CONFIGURATION-SET', $_ENV['SES_CONFIGURATION_SET']);
    }
}
