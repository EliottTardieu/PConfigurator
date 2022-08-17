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
        $country = App::getInstance()->auth->getCountry();
        $city = App::getInstance()->auth->getCity();
        if ($city != null) {
            $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
            $this->render("faculties.create", ["city" => $city]);
        } elseif ($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("faculties.create", ["cities" => City::getAll(["country_id" => $country->id])]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("faculties.create", ["cities" => City::getAll()]);
        }
    }

    #[NoReturn] public function createPost() {
        $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
        $faculty = new Component();
        if (Request::valuePost("name") && Request::valuePost("city_id") && Request::valuePost("code")) {
            $faculty->id = App::UUIDGenerator();
            $faculty->code = Request::valuePost("code");
            $faculty->name = Request::valuePost("name");
            $faculty->city_id = Request::valuePost("city_id");
            if ($faculty->save()) {
                $this->redirect(Router::route("faculties"), ["success" => "Faculty added successfully."]);
            }
        }
        $this->redirect(Router::route("faculties"), ["error" => "Unable to add the faculty."]);
    }

    public function edit($id) {
        $this->render("faculties.details", ["id" => $id, "cities" => City::getAll(), "students_incoming" => User::getAll(["faculty_arriving_id" => $id]), "students_outgoing" => User::getAll(["faculty_origin_id" => $id])]);
    }

    #[NoReturn] public function editPost($id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $faculty = Component::select(["id" => $id]);
            if (Request::valuePost("name") && Request::valuePost("city_id") && $faculty && $faculty->exists()) {
                $faculty->name = Request::valuePost("name");
                $faculty->city_id = Request::valuePost("city_id");
                if ($faculty->save()) {
                    $this->redirect(Router::route("faculties"), ["success" => "Faculty edited."]);
                }
            }
            $this->redirect(Router::route("faculties"), ["error" => "Unable to edit the faculty."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function delete($id) {
        try {
            $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
            $faculty = Component::select(["id" => $id]);
            if ($faculty != null && $faculty->exists() && empty($faculty->getAssociatedStudents())) {
                if ($faculty->delete()) {
                    $this->redirect(Router::route("faculties"), ["success" => "Faculty deleted."]);
                }
            }
            $this->redirect(Router::route("faculties"), ["error" => "Failed to delete the faculty."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }
}