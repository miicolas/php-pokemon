<?php

require_once './class/Pokemon.php';
require_once './class/Attaque.php';

?>

<!DOCTYPE html>
<html>


<head>
    <title>Pokemon</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<h1 class="text-3xl font-bold underline">Combat Pokemon</h1>

<?php

echo '<h2>'. $_GET["pokemon1"] . '</h2>';



?>
</body>
</html>
