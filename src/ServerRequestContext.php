<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack;

use Psr\Http\Message\ServerRequestInterface;

class ServerRequestContext
{
    public function __construct(private ServerRequestInterface $serverRequest)
    {
    }

    public function getServerRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }
}
