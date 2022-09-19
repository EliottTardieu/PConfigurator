<?php
/** @var Api[] $apis */

use PConfigurator\Controllers\Router;
use PConfigurator\Models\Api;

if(!empty($apis)) { ?>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>URL</th>
                            <th></th>
                        </tr>
                        <?php foreach ($apis as $api): ?>
                            <tr bgcolor="<?= $api->valid == 0 ? "lightgrey" : "white"; ?>">
                                <td><?= $api->name; ?></td>
                                <td><?= $api->url; ?></td>
                                <td><a class="button" href="<?= Router::route('api', ["id" => $api->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
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