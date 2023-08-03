<div class="footer" style="background-color: <?php echo $bg_color_1; ?>; border-top:1px solid <?php echo $border_color; ?>; float:right;">
<?php
$nRows = $pdo->query('SELECT count(*) FROM users')->fetchColumn();
?>
<big>Otorium</big><br />
<span>What are you building today?</span><br />
<img class="tooltip tooltip-left" data-tooltip="Don't trust the egg" onclick="alert('Succesfully transmitted 50,000 Otobux into your account'); $('body').hide(2500);" src="https://nutrigroupe.ca/wp-content/themes/nutri/images/Photo-egg-3.png" height="16" width="16" style="float:right;cursor:pointer;" />
<a href="<?php echo $url; ?>/help">Help</a> <strong>|</strong> <a href="<?php echo $url; ?>/forum/post/44">Terms & Privacy</a> <strong class="hide-sm">|</strong> <a class="hide-sm" style="text-decoration: none;"><?php echo $nRows-1; ?> users</a> <strong class="hide-sm">|</strong> <a class="hide-sm" style="text-decoration: none;"><?php $avatarReqs = $pdo->query("SELECT * FROM render_user WHERE rendered = 0")->rowCount(); echo $avatarReqs; ?> avatar request<?php if(!($avatarReqs == 1)) { echo 's'; } ?></a>
</div>
<?php $pdo = null; ?>