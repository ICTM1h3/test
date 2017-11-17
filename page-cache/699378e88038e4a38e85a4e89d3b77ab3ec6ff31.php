<?php 

// Imagine this was from a database. 
$users = ['<script>alert("Boe")</script>', '<h1>', 'Lorem', 'ipsum', 'dolor' ];
?>


<?php foreach ($users as $user) { ?>
	<?= htmlentities($user) ?><br />   
<?php } ?>