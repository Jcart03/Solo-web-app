<?php
/**
 * AdminController
 *
 * Manages Admin dashboard
 */

namespace P2718293\SoloWebDev2025\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use P2718293\SoloWebDev2025\Repos\InterestRepo;

class AdminController {

    private InterestRepo $interestRepo;
    private Twig $view;

    public function __construct(InterestRepo $interestRepo, Twig $view)
    {
        $this->interestRepo = $interestRepo;
        $this->view = $view;
    }

    public function dashboard(Request $request, Response $response): Response {
        $interests = $this->interestRepo->getAll();
        return $this->view->render($response, 'admin_dashboard.html.twig', [
            'interests' => $interests
        ]);
    }
}

