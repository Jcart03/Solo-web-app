<?php
/**
 * ProgrammeController
 *
 * For students, handles listing, viewing and registering interest
 * For admins, it handles creating, updating and deleting programmes
 */
    namespace P2718293\SoloWebDev2025\Controllers;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;
    use P2718293\SoloWebDev2025\Repos\ProgrammeRepo;


    class ProgrammeController {
        private ProgrammeRepo $programmeRepo;
        private Twig $view;

        public function __construct(ProgrammeRepo $programmeRepo, Twig $view) {
            $this->programmeRepo = $programmeRepo;
            $this->view = $view;
        }

        public function viewProgrammeSummaries(Request $request, Response $response): Response {
            $summaries = $this->programmeRepo->getAllSummaries();
            return $this->view->render($response, 'programmes.html.twig', ['programmes' => $summaries]);
        }

        public function viewProgramme(Request $request, Response $response, array $args): Response
        {
            $programmeId = (int)$args['id'];
            $programme = $this->programmeRepo->getById($programmeId);

            if(!$programme) {
                return $response->withStatus(404);
            }
            return $this->view->render($response, 'programme_detailed.html.twig', [
                'programme'=>[
                    'summary' => $programme->summary(),
                    'modules'=>$programme->modules()
                ]
                
            ]);
        }
    }