<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\RedirectResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Enum\Role;
use app\Exception\MasterRoleException;
use app\Exception\UserDoesntExistException;
use app\Request\AdminRequest;
use app\Service\AdminService\AdminService;
use app\Service\Auth\AuthService;
use app\Util\TemplateRenderer;
use app\View\Admin\AdminNavbarView;
use app\View\Admin\AdminPanelView;
use app\View\Util\NavbarView;

#[AllowDynamicProperties] class AdminPanelController
{

    public function __construct(TemplateRenderer $renderer,AdminService $adminService, AuthService $authService)
    {
        $this->renderer = $renderer;
        $this->adminService = $adminService;
        $this->authService = $authService;
    }

    #[Route('/admin','GET',[Role::admin, Role::master])]
    public function adminPanelView(AdminRequest $request) : ResponseInterface
    {
        if ($this->authService->isLoggedIn()){
            $adminPanelView = new AdminPanelView(new NavbarView());
            return new HtmlResponse($adminPanelView->renderWithRenderer($this->renderer));
        }else{
            return new RedirectResponse('/login', ['loginStatus' => 'notLogged']);
        }

    }

    #[Route('/admin/changeRole', 'POST', [Role::admin, Role::master])]
    public function changeRole(AdminRequest $request) : ResponseInterface
    {
        try {
            $this->adminService->changeUserRole($request->getUsername(), $request->getRole());
            return new JsonResponse(['success'=>true]);
        }catch (UserDoesntExistException $e){
            return new JsonResponse(['success'=>false , 'message' => $e->getMessage()]);
        }catch (MasterRoleException $e){
            return new JsonResponse(['success'=>false , 'message' => $e->getMessage()]);
        }
    }
}