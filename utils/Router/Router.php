<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router;

use Exception;
use http\Header;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
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
            throw new RouteNotFoundException($exception->getMessage(), 0, $exception);
        }

        foreach ($parameters as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        return $request;
    }

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        $controllerName = $request->getAttribute('_controller');

        if ($controllerName === null) {
            throw new ControllerNotConfiguredException();
        }

        $response = (new ResponseFactory())->createResponse(200);
        $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['success' => true]));

        return $response;
    }
}
