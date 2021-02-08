<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router as SymfonyRouter;
use Symfony\Component\Routing\Exception\MethodNotAllowedException as SymfonyMethodNotAllowedException;

class Router
{
    private SymfonyRouter $router;

    public function __construct(SymfonyRouter $router)
    {
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     * @throws MethodNotAllowedException
     */
    public function preProcessRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        try {
            $this->router->getContext()->setMethod($request->getMethod());

            $parameters = $this->router->match($request->getUri()->getPath());
        } catch (SymfonyMethodNotAllowedException $exception) {
            throw new MethodNotAllowedException($exception);
        } catch (Exception $exception) {
            throw new RouteNotFoundException($exception);
        }

        foreach ($parameters as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        return $request;
    }
}
