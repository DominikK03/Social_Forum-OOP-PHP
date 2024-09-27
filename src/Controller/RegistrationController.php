<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UsernameAlreadyExistsException;
use app\Repository\RegistrationRepository;
use app\Request\RegistrationDataRequest;
use app\Request\RegistrationPageRequest;
use app\Service\RegistrationService;
use app\Util\StaticValidator;
use app\Util\TemplateRenderer;
use app\View\RegisterView;

#[AllowDynamicProperties]
class RegistrationController
{
    public function __construct(RegistrationService $service, RegistrationRepository $repository, TemplateRenderer $renderer)
    {
        $this->registerView = new RegisterView();
        $this->service = $service;
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    #[Route('/register', 'GET')]
    public function registerView(RegistrationPageRequest $request): ResponseInterface
    {
        return new HtmlResponse($this->registerView->renderWithRenderer($this->renderer));
    }

    #[Route('/register', 'POST')]
    public function handleRegister(RegistrationDataRequest $request): ResponseInterface
    {
        try {
            $this->repository->registerUser(
                $this->service->setUserData(
                    $request->getName(),
                    $request->getEmail(),
                    $request->getPassword()
                ));
        } catch (EmailAlreadyExistsException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        } catch (UsernameAlreadyExistsException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
        return new JsonResponse(['success' => true]);
    }

}