<?php

use PConfigurator\Controllers\Router;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">API registration</span>
        </div>
        <form method="POST" action="<?= Router::route('api.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">URL</div>
                    <input name="url" class="value" type="text" value=""/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                        <a href="<?= Router::route('apis') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>