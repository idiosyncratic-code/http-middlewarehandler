# The Idiosyncratic HTTP Middleware Request Handler

Simple queue based PSR-15 Middleware Handler.


## Installation

```
composer require idiosyncratic/http-middlewarehandler
```

## Usage

Composing an instance requires:

- A fallback request handler implementing `Psr\Http\Server\RequestHandlerInterface`
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

While most PHP applications are designed so that script lifetime is for a single request, `MiddlewareRequestHandler` is designed to be usable in long lived scripts, such as an application built with a [ReactPHP](https://reactphp.org) or a similar library. Therefore, it is expected that middlewares and the services that they use are stateless as a single instance may service multiple requests.
