<?php

namespace PConfigurator\Core;

use AgileBundle\Utils\Dbg;
use PConfigurator\App;
use PConfigurator\Models\Component;
use JetBrains\PhpStorm\Pure;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class Auth {

    /**
     * Returns if the admin is connected or not
     *
     * @return bool
     */
    public function isAuth(): bool {
        if(isset($_SESSION["user_uid"])) {
            if($_SESSION["user_uid"] != null && $_SESSION["privilege_level"] >= 0)
                return true;
        }
        return false;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getAdminUID(): ?string {
        if($this->isAuth()) {
            return $_SESSION["user_uid"];
        }
        return null;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getPrivilegeLevel(): ?string {
        if($this->isAuth()) {
            return $_SESSION["privilege_level"];
        }
        return null;
    }

    /**
     * Disconnects the admin
     */
    public function logout(): void {
        $_SESSION["user_uid"] = "";
        $_SESSION["privilege_level"] = -1;
    }

    /**
     * Tries to connect the admin
     *
     * @param $mail string Mail of the admin
     * @param $password string Password of the admin
     * @return bool True if connection successful, false otherwise
     */
    public function login(string $mail, string $password): bool {
        try {
            $loginResult = App::getInstance()->firebase->auth->signInWithEmailAndPassword($mail, $password);
            $user = App::getInstance()->firebase->auth->getUser($loginResult->firebaseUserId());
            $this->auth($user);
            return true;
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
        }
        return false;
    }

    /**
     * Sets the current admin connected UID as admin.
     *
     * @param UserRecord $user
     */
    private function auth(UserRecord $user): void {
        !empty($user->customClaims) ? $_SESSION["privilege_level"] = $user->customClaims["privilege_level"] : $_SESSION["privilege_level"] = 0;
        $_SESSION["user_uid"] = $user->uid;
    }

}
