<?php ob_start(); ?>
<h1>Requete Ajax</h1>
<?php
while ($data = $DeviceAudio->fetch())
{
?>
    <div class="news">
        <p>
            <?= nl2br(htmlspecialchars($data['audio_model'])) ?>
            
            <em><a href="index.php?action=post&amp;id=<?= $data['audio_builder'] ?>">C</a></em>
        </p>
    </div>
<?php
}
$DeviceAudio->closeCursor();
?>
<?php $content = ob_get_clean(); 
echo $content;?>
