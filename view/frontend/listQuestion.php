<?php ob_start(); 
?>

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
                $question_save = '';
                $index = 0;
                //print_r($questions);
                foreach ($questions as $question) {
                    if ($question['header_designation'] != $question_save) {
                        $question_save = $question['header_designation'];
                        ?>
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox<?= $index ?>" name="options[]" value="<?= $question['header_id'] ?>">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>Question: <b><?= $question['header_designation'] ?></b></td><td></td><td></td><td></td></tr>
                        <?php
                        $index++;
                    }
                    ?>
                    <tr><td></td><td><?= $question['request_name'] ?></td><td><?= $question['request_libelle'] ?></td><td><?= $question['request_order'] ?></td>
                        <td>
                            <a href="routes.php?action=manageResponse&id=<?= $question['request_id'] ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>

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
