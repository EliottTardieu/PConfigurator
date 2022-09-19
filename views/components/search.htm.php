<?php
/** @var Component[] $components */

use PConfigurator\Controllers\Router;
use PConfigurator\Models\Component;

if(!empty($components)) { ?>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Manufacturer</th>
                            <th></th>
                        </tr>
                        <?php foreach ($components as $component): ?>
                            <tr bgcolor="<?= $component->obsolete != 0 ? "lightgrey" : "white"; ?>">
                                <td><?= $component->name; ?></td>
                                <td><?= $component->type; ?></td>
                                <td><?= $component->manufacturer; ?></td>
                                <td><a class="button" href="<?= Router::route('component', ["id" => $component->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
<label class="label">No result found.</label>
<?php }