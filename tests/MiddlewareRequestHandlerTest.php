<?php

declare(strict_types=1);

namespace Idiosyncratic\Http\Middleware;

use Idiosyncratic\Http\Middleware\Stub\BarMiddleware;
use Idiosyncratic\Http\Middleware\Stub\DefaultRequestHandler;
use Idiosyncratic\Http\Middleware\Stub\FooMiddleware;
use Idiosyncratic\Http\Middleware\Stub\PassThroughMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class MiddlewareRequestHandlerTest extends TestCase
{
    public function testHandlesRequestWithMiddleware() : void
    {
        $request = $this->createMock(ServerRequestInterface::class);

        $psrFactory = new Psr17Factory();

        $handler = new MiddlewareRequestHandler(
            new DefaultRequestHandler($psrFactory, $psrFactory),
            new PassThroughMiddleware(),
            new FooMiddleware($psrFactory),
            new BarMiddleware($psrFactory)
        );

        $response = $handler->handle($request);

        $this->assertEquals('foo', (string) $response->getBody());
    }

    public function testHandlesRequestWithDefaultHandler() : void
    {
        $request = $this->createMock(ServerRequestInterface::class);

        $psrFactory = new Psr17Factory();

        $handler = new MiddlewareRequestHandler(
            new DefaultRequestHandler($psrFactory, $psrFactory),
            new PassThroughMiddleware()
        );

        $response = $handler->handle($request);

        $this->assertEquals('default', (string) $response->getBody());
    }
}
