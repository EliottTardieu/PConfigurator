<?php

namespace PConfigurator\Controllers;

use AgileBundle\Utils\Request;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;
use PConfigurator\App;
use PConfigurator\Models\Api;

class ApiController extends ConfiguratorController {

    protected string $title = "Apis";

    public function displayAll() {
        $this->render("apis.list", ["apis" => Api::getAll()]);
    }

    public function create() {
        $this->render("apis.create");
    }

    #[NoReturn] public function createPost() {
        $api = new Api();
        if (Request::valuePost("name") && Request::valuePost("url")) {
            $api->id = App::UUIDGenerator();
            $api->name = Request::valuePost("name");
            $api->url = Request::valuePost("url");
            $api->valid = 1;
            if ($api->save()) {
                $this->redirect(Router::route("apis"), ["success" => "API added successfully."]);
            }
        }
        $this->redirect(Router::route("apis"), ["error" => "Unable to add the API."]);
    }

    public function edit($id) {
        $this->render("apis.details", ["id" => $id]);
    }

    #[NoReturn] public function editPost($id) {
        try {
            $api = Api::select(["id" => $id]);
            if (Request::valuePost("name") && Request::valuePost("url") && $api && $api->exists()) {
                $api->name = Request::valuePost("name");
                $api->url = Request::valuePost("url");
                if ($api->save()) {
                    $this->redirect(Router::route("apis"), ["success" => "API edited."]);
                }
            }
            $this->redirect(Router::route("apis"), ["error" => "Unable to edit the API."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function delete($id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $api = Api::select(["id" => $id]);
            if ($api != null && $api->exists()) {
                if ($api->delete()) {
                    $this->redirect(Router::route("apis"), ["success" => "API deleted."]);
                }
            }
            $this->redirect(Router::route("apis"), ["error" => "Failed to delete the API."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function changeAbility($id) {
        try {
            $api = Api::select(["id" => $id]);
            if ($api != null && $api->exists()) {
                if ($api->changeAbility()) {
                    $this->redirect(Router::route("apis"), ["success" => "API updated."]);
                }
            }
                $this->redirect(Router::route("apis"), ["error" => "Failed to update the API."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }
}