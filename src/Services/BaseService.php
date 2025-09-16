<?php

declare(strict_types=1);

namespace Verbania\SDK\Services;

use Verbania\SDK\Client;

abstract class BaseService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}