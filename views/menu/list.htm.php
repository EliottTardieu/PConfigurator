<?php
/**
 * @var UserRequest[] $requests
 */

use PConfigurator\App;
use PConfigurator\Models\UserRequest;

?>
<div class="row">
    <div class="row col-12 col-md-8 wr">
        <?php
        if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) {
            include "requests/list.htm.php";
        } else {
            include "requests/create.htm.php";
        }
        ?>
    </div>
</div>