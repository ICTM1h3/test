<?php

// Imagine this was from a database.
$users = ['<script>alert("Boe")</script>', '<h1>', 'Lorem', 'ipsum', 'dolor' ];

foreach ($users as $user) { 
?>
	{{$user}}<br />
<?php 
}