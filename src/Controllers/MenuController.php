<?php

namespace PConfigurator\Controllers;

use AgileBundle\Utils\Request;
use DateTime;
use PConfigurator\App;
use PConfigurator\Models\UserRequest;
use PConfigurator\Models\Component;
use PConfigurator\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class MenuController extends ConfiguratorController {

    protected string $title = "Menu";

    public function displayAll() {
        $this->render("menu.list");
    }

    #[NoReturn] public function requestCreate() {
        try {
            if (Request::valuePost("title") && Request::valuePost("content")) {
                $request = new UserRequest();
                $request->id = App::UUIDGenerator();
                $request->date = new DateTime();
                $request->content = Request::valuePost("content");
                $request->title = Request::valuePost("title");
                $request->status = 0;
                $request->author = App::getInstance()->firebase->auth->getUser(App::getInstance()->auth->getAdminUID())->email;
                $request->save();
                $this->redirect(Router::route("menu"), ["success", "Request sent successfully."]);
            }
            $this->redirect(Router::route("menu"), ["error", "Unable to create a new request."]);
        } catch (AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function requestReject(string $id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $request = UserRequest::select(["id" => $id]);
            if ($request != null && $request->exists()) {
                $request->status = 2;
                $request->save();
                $this->redirect(Router::route("menu"), ["success", "Request rejected."]);
            }
            $this->redirect(Router::route("menu"), ["error", "Unable to change the request status."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function requestValidate(string $id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $request = UserRequest::select(["id" => $id]);
            if ($request != null && $request->exists()) {
                $request->status = 1;
                $request->save();
                $this->redirect(Router::route("menu"), ["success", "Request validated."]);
            }
            $this->redirect(Router::route("menu"), ["error", "Unable to change the request status."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }
}