<?php
/**
 * AuthController
 *
 * Handles admin authentication, including login and logout.
 * Manages session setup and access control enforcement
 *
 */

 namespace P2718293\SoloWebDev2025\Controllers;
 
 use Psr\Http\Message\ResponseInterface as Response;
 use Psr\Http\Message\ServerRequestInterface as Request;
 use P2718293\SoloWebDev2025\Repos\UserRepo;
 use P2718293\SoloWebDev2025\Security\Validator;
 use P2718293\SoloWebDev2025\Security\Sanitiser;
 use Slim\Views\Twig;
 

 class AuthController {
    private UserRepo $userRepo;
    private Twig $view;

    /**
     * expected fields from login form along with their types
     */
    private const LOGIN_FIELDS = [
        'email' => 'email',
        'password' => 'string'
    ];
    /**
     * AuthController constructor
     * @param UserRepo $userRepo - Handles user data retrieval
     * @param Twig $view - Twig view renderer injected into the controller
     */
    public function __construct(UserRepo $userRepo, Twig $view) {
        $this->userRepo = $userRepo;
        $this->view = $view;
    }
    /**
     * Renders Login page.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showLogin(Request $request, Response $response): Response {
        return $this->view->render($response, 'login.html.twig');
    }

    public function handleLogin(Request $request, Response $response): Response {
        $raw = $request->getParsedBody();

        $data = Sanitiser::sanitiseForm($raw, self::LOGIN_FIELDS);
        $errors = Validator::validateLogin($data);
        
        if (!empty($errors)) {
            return $this->view->render($response,
            'login.html.twig',[
                'errors' => $errors
                ]);
        }
        error_log($data['password']);
        $user = $this->userRepo->getByEmail($data['email']);
        error_log(print_r($user, true));
        error_log('Password verified: '. (password_verify($data['password'], $user->passwordHash()) ? 'yes' : 'no'));
        if ($user && password_verify($data['password']?? '', $user->passwordHash())) {
            session_start();
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->id();


            return $response->withHeader('Location', '/admin')->withStatus(302);
        }

        return $this->view->render($response, 'login.html.twig', ['errors' => ['Invalid email or password']]);
    }

    public function logout(Request $request, Response $response): Response {
        session_start();
        session_destroy();

        return $response
            ->withHeader('Location', '/login')
            ->withStatus(302);
    }
 }
