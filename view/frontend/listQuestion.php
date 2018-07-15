<?php ob_start(); ?>
      <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Nom</th>
                    <th>Libellé</th>
                    <th>Ordre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $request_save = '';
                $index = 0;
                foreach ($requests as $request) {
                    if ($request['header_designation'] != $request_save) {
                        $request_save = $request['header_designation'];
                        ?>
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox<?= $index ?>" name="options[]" value="1">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>Question: <b><?= $request['header_designation'] ?></b></td><td></td><td></td><td></td></tr>
                        <?php
                        $index++;
                    }
                    ?>
                    <tr><td></td><td><?= $request['request_name'] ?></td><td><?= $request['request_libelle'] ?></td><td><?= $request['request_order'] ?></td>
                        <td>
                            <a href="routes.php?action=majOneRequest&id=<?= $request['request_id'] ?>&bu=<?= $request['header_bu'] ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>

                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?> 
            </tbody>
        </table>
<?php
$content = ob_get_clean();
echo $content;
?>
