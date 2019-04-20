<?php

declare(strict_types=1);

namespace Idiosyncratic\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function array_shift;

final class MiddlewareRequestHandler implements RequestHandlerInterface
{
    /** @var array|MiddlewareInterface[] */
    private $middleware;

    /** @var RequestHandlerInterface */
    private $defaultHandler;

    public function __construct(
        RequestHandlerInterface $defaultHandler,
        MiddlewareInterface ...$middleware
    ) {
        $this->defaultHandler = $defaultHandler;

        $this->middleware = $middleware;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $handler = clone $this;

        $nextHandler = $handler->getNextHandler();

        return $nextHandler instanceof MiddlewareInterface ?
            $nextHandler->process($request, $handler) :
            $this->defaultHandler->handle($request);
    }

    /**
     * Gets the next Middleware off of the middleware stack, or null if the end of the
     * stack is reached
     */
    protected function getNextHandler() : ?MiddlewareInterface
    {
        return array_shift($this->middleware);
    }
}
