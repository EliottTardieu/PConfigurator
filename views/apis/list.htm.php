<?php
/** @var Api[] $apis */

use PConfigurator\Controllers\Router;
use PConfigurator\Models\Api;

?>
<div class="flex-column">
    <div class="row no-padding col-6">
        <div class="box-content">
            <label class="m-1" for="searchBar">Enter an API name:</label>
            <input id="searchBar" type="text" class="input m-auto" />
        </div>
    </div>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table <?= empty($apis) ? 'empty' : '' ?>">
                        <tr>
                            <th>Name</th>
                            <th>URL</th>
                            <th><a class="button" href="<?= Router::route('api.create.page') ?>"><i class="far fa-eye r"></i>Add an API</a></th>
                        </tr>
                        <?php
                        if(!empty($apis)) {
                            foreach ($apis as $api): ?>
                                <tr bgcolor="<?= $api->valid == 0 ? "lightgrey" : "white"; ?>">
                                    <td><?= $api->name; ?></td>
                                    <td><?= $api->url; ?></td>
                                    <td><a class="button" href="<?= Router::route('api', ["id" => $api->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let excelModal;

    window.addEventListener("load", () => {
        excelModal = new Modal({view_url: '<?= Router::route("users.excel")?>', title: 'Import your Excel file here:'});
        excelModal.build();
    });

    document.getElementById("searchBar").addEventListener('change', updateList);
    let data = <?php echo json_encode($apis); ?>;

    function updateList() {
        if(!(this.value === "")) {
            let random = Math.floor(Math.random() * 1000);
            if (random === 0) {
                window.open("https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley");
            } else {
                let toReturn = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i]["name"].toLowerCase().includes(this.value.toLowerCase())) {
                        toReturn.push(data[i]);
                    }
                }
                let searchModal = new Modal({
                    view_url: '<?= Router::route("apis.search")?>',
                    view_data: toReturn,
                    title: 'Search Result'
                });
                searchModal.build();
                searchModal.show();
            }
        }
    }
</script>