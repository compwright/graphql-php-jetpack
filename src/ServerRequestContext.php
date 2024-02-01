<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack;

use Psr\Http\Message\ServerRequestInterface;

class ServerRequestContext
{
    private ServerRequestInterface $serverRequest;

    public function __construct(ServerRequestInterface $serverRequest)
    {
        $this->serverRequest = $serverRequest;
    }

    public function getServerRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }
}
