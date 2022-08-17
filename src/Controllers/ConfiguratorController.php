<?php

namespace PConfigurator\Controllers;

use PConfigurator\App;

abstract class ConfiguratorController extends Controller {

    protected bool $requireAuth = true;
    protected string $layout = "configurator";

    /**
     * Checks the privileges and redirect to configuration page if not enough privileges.
     *
     * @param int $privilegeLevel if null (so = -1 by default), will take into account the requirePrivilege variable.
     * @return void
     */
    protected function requirePrivileges(int $privilegeLevel = -1): void {
        if($privilegeLevel == -1) $privilegeLevel = $this->requirePrivilege;
        if($this->requirePrivilege > 0) {
            if(App::getInstance()->auth->getPrivilegeLevel() > $privilegeLevel) {
                $this->redirect(Router::route("configuration"), ["error" => "You are not allowed to do this."]);
            }
        }
    }
}