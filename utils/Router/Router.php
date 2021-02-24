<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router;

use Coolblue\Utils\Router\Exception\BuildControllerException;
use Coolblue\Utils\Router\Exception\ControllerNotConfiguredException;
use Coolblue\Utils\Router\Exception\ControllerNotFoundException;
use Coolblue\Utils\Router\Exception\InvalidControllerException;
use Coolblue\Utils\Router\Exception\MethodNotAllowedException;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException as SymfonyMethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router as SymfonyRouter;

class Router
{
    private SymfonyRouter $router;
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, SymfonyRouter $router)
    {
        $this->router = $router;
        $this->container = $container;
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
            throw new RouteNotFoundException($exception->getMessage(), 0, $exception);
        }

        foreach ($parameters as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        return $request;
    }

    public function warm(): void
    {
        try {
            $this->router->match('');
        } catch (\Throwable $exception) {
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws BuildControllerException
     * @throws ControllerNotConfiguredException
     * @throws ControllerNotFoundException
     * @throws InvalidControllerException
     */
    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        $controllerName = $request->getAttribute('_controller');

        if ($controllerName === null) {
            throw new ControllerNotConfiguredException();
        }

        $controller = $this->buildController($controllerName);

        return $controller->handle($request);
    }

    /**
     * @param string $controllerName
     * @return RequestHandlerInterface
     * @throws ControllerNotFoundException
     * @throws InvalidControllerException
     */
    private function buildController(string $controllerName): RequestHandlerInterface
    {
        if ($this->container->has($controllerName) === false) {
            throw new ControllerNotFoundException();
        }

        try {
            $controller = $this->container->get($controllerName);
        } catch (Exception $exception) {
            throw new BuildControllerException($exception);
        }

        if ($controller instanceof RequestHandlerInterface === false) {
            throw new InvalidControllerException();
        }

        return $controller;
    }
}
