<?php

use PConfigurator\Controllers\Router;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Component registration</span>
        </div>
        <form method="POST" action="<?= Router::route('component.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Type</div>
                    <input name="type" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Manufacturer</div>
                    <input name="manufacturer" class="value" type="text" value=""/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('components') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>