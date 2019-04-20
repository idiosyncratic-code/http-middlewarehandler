<?php

declare(strict_types=1);

namespace Idiosyncratic\Http\Middleware\Stub;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DefaultRequestHandler implements RequestHandlerInterface
{
    /** @var ResponseFactoryInterface */
    private $response;

    /** @var StreamFactoryInterface */
    private $stream;

    public function __construct(
        ResponseFactoryInterface $response,
        StreamFactoryInterface $stream
    ) {
        $this->response = $response;

        $this->stream = $stream;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $response = $this->response->createResponse(200, '0K')
                         ->withBody($this->stream->createStream());

        $response->getBody()->write('default');

        return $response;
    }
}
