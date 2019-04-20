# The Idiosyncratic HTTP Middleware Request Handler

Fast, simple queue based PSR-15 Middleware Handler.

## Installation

```
composer require idiosyncratic/http-middlewarehandler
```

## Usage

Composing an instance requires:

- a Fallback Request Handler implementing `Psr\Http\Server\RequestHandlerInterface`
- One or more middlewares implementing `Psr\Http\Server\MiddlewareInterface`

```
use Idiosyncratic\Http\Middleware\MiddlewareRequestHandler;

$handler = new MiddlewareRequestHandler(
    new PsrRequestHandler(),
    new PsrMiddlewareOne(),
    new PsrMiddlewareTwo(),
    new PsrMiddlewareThree(),
);

$response = $handler->handle($psrServerRequest);
```
