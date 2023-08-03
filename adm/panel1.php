<div style="padding:25px; border:1px solid rgb(200,200,200);">
  <h5>Tools</h5>
  <ul>
	  <li><a href="<?php $url; ?>/adm/ban">Ban User</a></li>
	  <li><a href="<?php $url; ?>/adm/unban">Unban user</a></li>
	  <li><a href="<?php $url; ?>/adm/reports">Reports</a></li>
	  <li><a href="<?php $url; ?>/adm/asset_approval" <?php if($assetsapprovalpending > 0) { echo 'class="badge" data-badge="'.$assetsapprovalpending.'"'; } ?>>Asset Approval</a></li>
	  <li><a href="<?php $url; ?>/adm/restrictions">Restrictions</a> <span style="color: red;">preview!</span></li>
  </ul>
  <h5>Admins only</h5>
  <ul>
	  <li><a href="<?php $url; ?>/adm/announcement">Change announcement</a></li>
	  <li><a href="<?php $url; ?>/adm/registration">Registration</a></li>
	  <li><a href="<?php $url; ?>/adm/minfo">Maintenance</a></li>
	  <li><a href="<?php $url; ?>/adm/encrypt">Encrypt</a></li>
	  <li><a href="<?php $url; ?>/adm/giveasset">Give asset</a></li>
	  <li><a href="<?php $url; ?>/adm/users">Users</a></li>
  </ul>
</div>