<?php
/**
 * @var int $id
 */


use PConfigurator\App;
use PConfigurator\Controllers\Router;
use PConfigurator\Models\Component;
use PConfigurator\Models\User;

?>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="row">
            <div class="box col-12 wr">
                <div class="box-header">
                    <span class="box-title"><?php
                        $component = Component::select(["id" => $id]);
                        echo $component->manufacturer . " " . $component->name;
                        ?></span>
                </div>
                <form method="POST" action="<?= Router::route('component.edit', ["id" => $component->id]) ?>">
                    <div class="box-content">
                        <div class="field">
                            <div class="label">Identifier</div>
                            <input name="id" class="value" type="text" value="<?= $component->id; ?>" disabled/>
                        </div>
                        <div class="field">
                            <div class="label">Name</div>
                            <input name="name" class="value" type="text" value="<?= $component->name; ?>" />
                        </div>
                        <div class="field">
                            <div class="label">Type</div>
                            <input name="type" class="value" type="text" value="<?= $component->type; ?>" />
                        </div>
                        <div class="field">
                            <div class="label">Manufacturer</div>
                            <input name="manufacturer" class="value" type="text" value="<?= $component->manufacturer; ?>" />
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="button-group">
                            <a href="<?= Router::route('components') ?>" class="button">Cancel</a>
                            <?php if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
                                <a onclick="confirm('Confirm the component removal request ?') ? window.location = '<?= Router::route('component.delete', ["id" => $component->id]) ?>' : void(0)" class="button red">Delete</a>
                            <?php }
                            $ability = $component->obsolete != 0 ?>
                            <a onclick="confirm('Confirm the component update request ?') ? window.location = '<?= Router::route('component.ability', ["id" => $component->id]) ?>' : void(0)" class="button <?= $ability ? "green" : "red" ?>"><?= $ability ? "Up to date" : "Obsolete" ?></a>
                            <button type="submit" class="button cta">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

