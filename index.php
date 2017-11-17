<?php
// Load the file which handles loading the actual webpage.
include 'rendering.php';
?>

<!DOCTYPE html>
<html>
<head>
<!-- css files, etc -->
</head>

<body>
	<div style="display:flex; justify-content:space-around;">
		<a href="?p=safe">Veilige pagina</a>
		<a href="?p=unsafe">Onveilige pagina</a>
	</div>
<?php
	echo renderPage();
?>
</body>
</html>
