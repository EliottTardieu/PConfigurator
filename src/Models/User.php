<?php

namespace PConfigurator\Models;

use AgileBundle\Utils\Dbg;
use PConfigurator\App;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class User extends Model {

    const STORAGE = 'users';

    const COLUMNS = ["id", "lastname", "firstname"];

    public $lastname;
    public $firstname;
    private $authUser = null;

    public function __construct(array $data = null) {
        parent::__construct($data);
        try {
            if ($this->exists()) {
                $this->authUser = App::getInstance()->firebase->auth->getUser($this->id);
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
        }
    }

    /**
     * Returns the email for the user.
     *
     * @return string|null
     */
    public function getEmail(): ?string {
        if($this->authUser) {
            return $this->authUser->email;
        } else {
            Dbg::error("Unable to find email for such user.");
            return null;
        }
    }

    /**
     * Disable the current user if it was enabled / Enable the current user if it was disabled.
     *
     * @return bool
     */
    public function changeAbility(): bool {
        try {
            if ($this->authUser) {
                if ($this->isDisabled()) {
                    $properties = array(
                        "disabled" => false
                    );
                } else {
                    $properties = array(
                        "disabled" => true
                    );
                }
                App::getInstance()->firebase->auth->updateUser($this->id, $properties);
                $this->authUser = App::getInstance()->firebase->auth->getUser($this->id);
                return true;
            } else {
                Dbg::error("Unable to update the user ability.");
                return false;
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
            return false;
        }
    }

    /**
     * Return is the user is disabled or not.
     *
     * @return bool|null
     */
    public function isDisabled(): ?bool {
        if($this->authUser) {
            return $this->authUser->disabled;
        } else {
            Dbg::error("Unable to find auth entity for such user.");
            return null;
        }
    }

}