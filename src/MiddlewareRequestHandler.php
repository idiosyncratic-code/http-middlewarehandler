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
        $runner = clone $this;

        $handler = $runner->getNextHandler();

        return $handler instanceof MiddlewareInterface ?
            $handler->process($request, $runner) :
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
