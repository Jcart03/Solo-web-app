<?php
/**
 * Route definitions for the Slim app
 * This file defines all the public routes and their handlers.
 * More routes will be added in the feature branches
 *
 * (Update - modified it to comply with SonarQube)
 */
namespace P2718293\SoloWebDev2025\routes;

use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use P2718293\SoloWebDev2025\DbHelper\Database;
use P2718293\SoloWebDev2025\Controllers\ProgrammeController;
use P2718293\SoloWebDev2025\Controllers\AuthController;
use P2718293\SoloWebDev2025\Controllers\AdminController;
use P2718293\SoloWebDev2025\Controllers\InterestController;

use P2718293\SoloWebDev2025\Middleware\AuthMiddleware;

use P2718293\SoloWebDev2025\Repos\UserRepo;
use P2718293\SoloWebDev2025\Repos\ProgrammeRepo;
use P2718293\SoloWebDev2025\Repos\InterestRepo;
use P2718293\SoloWebDev2025\Repos\ModuleRepo;
use P2718293\SoloWebDev2025\Repos\StaffRepo;

use PDO;

class Web {
    public static function register(App $app, Twig $twig): void {

        
        $rootPath = dirname(__DIR__,2);
        $pdo = Database::connect();

        $staffRepo = new StaffRepo($pdo);
        $moduleRepo = new ModuleRepo($pdo, $staffRepo);
        $programmeRepo = new ProgrammeRepo($pdo, $moduleRepo);
        $programmeController = new ProgrammeController($programmeRepo, $twig);


        $userRepo = new UserRepo($pdo);
        $authController = new AuthController($userRepo, $twig);

        $interestRepo = new InterestRepo($pdo);
        $interestController = new InterestController($interestRepo, $programmeRepo, $twig);

        $adminController = new AdminController($interestRepo, $twig);

       
        $app->get('/', function(Request $request, Response $response) use ($twig): Response {
            return $twig->render($response, 'home.html.twig');
        });

        $app->get('/login', function(Request $request, Response $response) use ($authController) {
            return $authController->showLogin($request, $response);

        });

        $app->post('/login', function(Request $request, Response $response) use ($authController) {
            return $authController->handleLogin($request, $response);
        });

        $app->get('/programmes', function(Request $request, Response $response) use ($programmeController) {
            return $programmeController->viewProgrammeSummaries($request, $response);
        });

        $app->get('/programme/{id}', function(Request $request, Response $response, array $args) use ($programmeController) {
            
            return $programmeController->viewProgramme($request, $response, $args);
        });

        $app->get('/interest', function(Request $request, Response $response) use ($interestController) {
            return $interestController->form($request, $response);
        });
        $app->post('/interest', function(Request $request, Response $response) use ($interestController) {
            return $interestController->submit($request, $response);
        });
        $app->get('/interest/confirmation', function(Request $request, Response $response) use ($interestController) {
            return $interestController->confirmation($request, $response);
        });

        $app->get('/admin', function(Request $request, Response $response) use ($adminController) {
            return $adminController->dashboard($request, $response);
        })->add(AuthMiddleware::class);

        $app->any('/{routes:.+}', function (Request $request, Response $response) {
            $response->getBody()->write("404 Not Found");
            return $response->withStatus(404);
        });
    }
}
