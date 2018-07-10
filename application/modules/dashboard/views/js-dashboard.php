<script>
<?php 
 if (!isset($_COOKIE['action'])) {
  setcookie('action','myaction');
  ?>
  $(document).ready(function() {
			 var options = $.parseJSON($('.noty').attr('data-noty-options'));
		     noty(options);
			});
  <?php
}
?>

</script>