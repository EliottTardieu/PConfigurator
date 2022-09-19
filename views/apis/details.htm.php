<?php
/**
 * @var int $id
 */


use PConfigurator\App;
use PConfigurator\Controllers\Router;
use PConfigurator\Models\Api;

?>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="row">
            <div class="box col-12 wr">
                <div class="box-header">
                    <span class="box-title"><?php
                        $api = Api::select(["id" => $id]);
                        echo $api->name;
                        ?></span>
                </div>
                <form method="POST" action="<?= Router::route('api.edit', ["id" => $api->id]) ?>">
                    <div class="box-content">
                        <div class="field">
                            <div class="label">Identifier</div>
                            <input name="id" class="value" type="text" value="<?= $api->id; ?>"disabled/>
                        </div>
                        <div class="field">
                            <div class="label">Name</div>
                            <input name="name" class="value" type="text" value="<?= $api->name; ?>"/>
                        </div>
                        <div class="field">
                            <div class="label">URL</div>
                            <input name="url" class="value" type="text" value="<?= $api->url; ?>"/>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="button-group">
                            <a href="<?= Router::route('apis') ?>" class="button">Cancel</a>
                            <?php if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
                                <a onclick="confirm('Confirm the API removal request ?') ? window.location = '<?= Router::route('api.delete', ["id" => $api->id]) ?>' : void(0)" class="button red">Delete</a>
                            <?php }
                            $ability = $api->valid == 0; ?>
                                <a onclick="confirm('Confirm the API update request ?') ? window.location = '<?= Router::route('api.ability', ["id" => $api->id]) ?>' : void(0)" class="button <?= $ability ? "green" : "red" ?>"><?= $ability ? "Enable" : "Disable" ?></a>
                            <button type="submit" class="button cta">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

