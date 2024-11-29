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
<body class="bg-black text-white w-full h-screen flex flex-col items-center gap-10 justify-around py-20">
<div class="mx-auto">
    <h1 class="text-3xl font-medium text-center">C'est l'heure de<br/><span class="font-bold">Combattre <img src="assets/pokeball.svg"
                                                                                        alt="Pokeball" class="inline-block w-6 h-6"></span>
    </h1>
</div>

<div class="flex gap-10 items-center">
    <img src="./assets/tortank.png" alt="Pokemon 1" class="inline-block w-52 h-52">
    <div class="bg-gray-300/50 rounded-lg p-2 w-fit"><p>V/S</p></div>
    <img src="./assets/drakofeu.png" alt="Pokemon 2" class="inline-block w-52 h-52">

</div>

<?php

$pokemon1 = $_POST['pokemon1'];
$pokemon2 = $_POST['pokemon2'];

echo $pokemon1;
echo $pokemon2;




?>
</body>
</html>
