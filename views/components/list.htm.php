<?php
/** @var Component[] $components */

use PConfigurator\Controllers\Router;
use PConfigurator\Models\Component;

?>
<div class="flex-column">
    <div class="row no-padding col-6">
        <div class="box-content">
            <label class="m-1" for="searchBar">Enter a component name:</label>
            <input id="searchBar" type="text" class="input m-auto" />
        </div>
    </div>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table <?= empty($components) ? 'empty' : '' ?>">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Manufacturer</th>
                            <th><a class="button" onclick="excelModal.show();"><i class="far fa-eye r"></i>Excel Import</a></th>
                        </tr>
                        <?php
                        if(!empty($components)) {
                            foreach ($components as $component): ?>
                                <tr bgcolor="<?= $component->obsolete != 0 ? "lightgrey" : "white"; ?>">
                                    <td><?= $component->name; ?></td>
                                    <td><?= $component->type; ?></td>
                                    <td><?= $component->manufacturer; ?></td>
                                    <td><a class="button" href="<?= Router::route('component', ["id" => $component->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
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
    let data = <?php echo json_encode($components); ?>;

    function updateList() {
        if(!(this.value === "")) {
            let random = Math.floor(Math.random() * 1000);
            if (random === 0) {
                window.open("https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley");
            } else {
                let toReturn = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i]["lastname"].toLowerCase().includes(this.value.toLowerCase())) {
                        toReturn.push(data[i]);
                    }
                }
                let searchModal = new Modal({
                    view_url: '<?= Router::route("users.search")?>',
                    view_data: toReturn,
                    title: 'Search Result'
                });
                searchModal.build();
                searchModal.show();
            }
        }
    }
</script>