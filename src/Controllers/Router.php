<?php

namespace PConfigurator\Controllers;

use AgileBundle\Controllers\AbstractRouter;

class Router extends AbstractRouter
{

    protected static function getDomain(): string
    {
        return PUBLIC_DOMAIN;
    }

    protected static function getRelativeDir(): string
    {
        return RELATIVE_DIR_PUBLIC;
    }

    protected static function getControllerClass(): string
    {
        return HomeController::class;
    }

    protected static function getRoutes(): array
    {
        return [
            '/'                             => ["GET", "/", [HomeController::class, "home"]],
            'login'                         => ["GET", "/login", [AuthController::class, "login"]],
            'logout'                        => ["GET", "/logout", [AuthController::class, "logout"]],
            'auth'                          => ["POST", "/auth", [AuthController::class, "auth"]],
            'account'                       => ["GET", "/account", [AccountController::class, "edit"]],
            'account.edit'                  => ["POST", "/account/edit", [AccountController::class, "editPost"]],
            'menu'                          => ["GET", "/menu", [MenuController::class, "displayAll"]],
            'menu.request.history'          => ["POST", "/menu/request/history", [ModalController::class, "requestsHistory"]],
            'menu.request.reject'           => ["GET", "/menu/request/reject/{id}", [MenuController::class, "requestReject"]],
            'menu.request.validate'         => ["GET", "/menu/request/validate/{id}", [MenuController::class, "requestValidate"]],
            'menu.request.create'           => ["POST", "/menu/request/create", [MenuController::class, "requestCreate"]],
            'menu.request'                  => ["POST", "/menu/request", [ModalController::class, "requestDetails"]],
            'users'                         => ["GET", "/users", [UserController::class, "displayAll"]],
            'users.search'                  => ["POST", "/users/search", [ModalController::class, "searchUsers"]],
            'users.excel'                   => ["POST", "/users/excel", [ModalController::class, "importExcel"]],
            'users.excel.create'            => ["POST", "/users/excel/create", [ModalController::class, "importExcelPost"]],
            'user.ability'                  => ["GET", "/user/ability/{id}", [UserController::class, "changeAbility"]],
            'user.edit'                     => ["POST", "/user/edit/{id}", [UserController::class, "editPost"]],
            'user'                          => ["GET", "/user/{id}", [UserController::class, "edit"]],
            'components'                    => ["GET", "/components", [ComponentsController::class, "displayAll"]],
            'components.search'             => ["POST", "/components/search", [ModalController::class, "searchComponents"]],
            'component.create.page'         => ["GET", "/component/create", [ComponentsController::class, "create"]],
            'component.create'              => ["POST", "/component/new", [ComponentsController::class, "createPost"]],
            'component.delete'              => ["GET", "/component/delete/{id}", [ComponentsController::class, "delete"]],
            'component.edit'                => ["POST", "/component/edit/{id}", [ComponentsController::class, "editPost"]],
            'component.ability'             => ["GET", "/component/ability/{id}", [ComponentsController::class, "changeAbility"]],
            'component'                     => ["GET", "/component/{id}", [ComponentsController::class, "edit"]],
            'apis'                          => ["GET", "/apis", [ApiController::class, "displayAll"]],
            'apis.search'                   => ["POST", "/apis/search", [ModalController::class, "searchApis"]],
            'api.create.page'               => ["GET", "/api/create", [ApiController::class, "create"]],
            'api.create'                    => ["POST", "/api/new", [ApiController::class, "createPost"]],
            'api.delete'                    => ["GET", "/api/delete/{id}", [ApiController::class, "delete"]],
            'api.edit'                      => ["POST", "/api/edit/{id}", [ApiController::class, "editPost"]],
            'api.ability'                   => ["GET", "/api/ability/{id}", [ApiController::class, "changeAbility"]],
            'api'                           => ["GET", "/api/{id}", [ApiController::class, "edit"]]
        ];
    }
}