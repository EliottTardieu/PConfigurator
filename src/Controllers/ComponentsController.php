<?php

namespace PConfigurator\Controllers;

use AgileBundle\Utils\Request;
use PConfigurator\App;
use PConfigurator\Models\Component;
use PConfigurator\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class ComponentsController extends ConfiguratorController {

    protected string $title = "Components";

    public function displayAll() {
        $this->render("components.list", ["components" => Component::getAll()]);
    }

    public function create() {
        $this->render("components.create");
    }

    #[NoReturn] public function createPost() {
        $component = new Component();
        if (Request::valuePost("name") && Request::valuePost("type") && Request::valuePost("manufacturer")) {
            $component->id = App::UUIDGenerator();
            $component->type = Request::valuePost("type");
            $component->name = Request::valuePost("name");
            $component->manufacturer = Request::valuePost("manufacturer");
            $component->obsolete = 0;
            if ($component->save()) {
                $this->redirect(Router::route("components"), ["success" => "Component added successfully."]);
            }
        }
        $this->redirect(Router::route("components"), ["error" => "Unable to add the component."]);
    }

    public function edit($id) {
        $this->render("components.details", ["id" => $id]);
    }

    #[NoReturn] public function editPost($id) {
        try {
            $component = Component::select(["id" => $id]);
            if (Request::valuePost("name") && Request::valuePost("type") && Request::valuePost("manufacturer") && $component && $component->exists()) {
                $component->name = Request::valuePost("name");
                $component->type = Request::valuePost("type");
                $component->manufacturer = Request::valuePost("manufacturer");
                if ($component->save()) {
                    $this->redirect(Router::route("components"), ["success" => "Component edited."]);
                }
            }
            $this->redirect(Router::route("components"), ["error" => "Unable to edit the Component."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function delete($id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $component = Component::select(["id" => $id]);
            if ($component != null && $component->exists()) {
                if ($component->delete()) {
                    $this->redirect(Router::route("components"), ["success" => "Component deleted."]);
                }
            }
            $this->redirect(Router::route("components"), ["error" => "Failed to delete the component."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function changeAbility($id) {
        try {
            $component = Component::select(["id" => $id]);
            if ($component != null && $component->exists()) {
                if ($component->changeAbility()) {
                    $this->redirect(Router::route("components"), ["success" => "Component updated."]);
                }
            }
            $this->redirect(Router::route("components"), ["error" => "Failed to update the component."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }
}