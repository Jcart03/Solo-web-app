<?php

namespace P2718293\SoloWebDev2025\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Factory\AppFactory;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response {
        session_start();

        if(!isset($_SESSION['user_id'])) {
            $response = AppFactory::createResponse();
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }
        return $handler->handle($request);
    }
}
