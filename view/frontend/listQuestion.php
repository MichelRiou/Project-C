<?php ob_start(); 
?>
<!-- RECUPERATION D'UN TABLEAU ET NON D'UN OBJET -->
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
                    if ($question['request_id']!= null){?>
                        
                    <tr><td></td><td><?= $question['request_name'] ?></td><td><?= $question['request_libelle'] ?></td><td><?= $question['request_order'] ?></td>
                        <td class="row">
                            <a href="routes.php?action=manageTagResponse&id=<?= $question['request_id'] ?>" 
                               class="view"><i class="material-icons" data-toggle="tooltip" title="Liste">&#xE242;</i></a>
                            <a href="#editFormModal" idresponse="<?= $question['request_id'] ?>" 
                               name="<?= $question['request_name'] ?>"  libelle="<?= $question['request_libelle'] ?>" 
                               order="<?= $question['request_order'] ?>"  class="edit" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteResponseModal" idresponse="<?= $question['request_id'] ?>" class="delete" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php
                }
                }
                ?> 
            </tbody>
        </table>
<?php
$content = ob_get_clean();
echo $content;
?>
