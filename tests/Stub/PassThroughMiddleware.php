<?php

declare(strict_types=1);

namespace Idiosyncratic\Http\Middleware\Stub;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PassThroughMiddleware implements MiddlewareInterface
{
    /**
     * @inheritdoc
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {
        return $handler->handle($request);
    }
}
