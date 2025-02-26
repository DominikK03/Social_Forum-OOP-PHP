<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\ErrorResponses\NotLoggedInRedirectResponse;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Response\SuccessfullResponse;
use app\Core\HTTP\Response\UnsuccessfullResponse;
use app\Enum\Role;
use app\Exception\MasterRoleException;
use app\Exception\UserDoesntExistException;
use app\Request\AdminRequest;
use app\Service\AdminService\AdminService;
use app\Service\Auth\AuthService;
use app\Util\TemplateRenderer;
use app\View\ViewFactory;

#[AllowDynamicProperties]
class AdminPanelController
{
    public function __construct(
        TemplateRenderer $renderer,
        AdminService $adminService,
        AuthService $authService,
        ViewFactory $viewFactory
    )
    {
        $this->renderer = $renderer;
        $this->adminService = $adminService;
        $this->authService = $authService;
        $this->viewFactory = $viewFactory;
    }
    #[Route('/admin', 'GET', [Role::admin])]
    public function adminPanelView(AdminRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            return new HtmlResponse($this->viewFactory->createAdminPanelView()->renderWithRenderer($this->renderer));
        } else {
            return new NotLoggedInRedirectResponse();
        }
    }
    #[Route('/admin/changeRole', 'POST', [Role::admin])]
    public function changeRole(AdminRequest $request): ResponseInterface
    {
        try {
            $this->adminService->changeUserRole($request->getUsername(), $request->getRole());
            return new SuccessfullResponse();
        } catch (UserDoesntExistException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        } catch (MasterRoleException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        }
    }
}