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
    <h1 class="text-3xl font-bold text-center">Sélectionne tes <br/><span>Pokemons <img src="./assets/pokeball.svg"
                                                                                      alt="Pokeball" class="inline-block w-6 h-6"></span>
    </h1>
</div>
<?php
$json = file_get_contents('./pokemons.json');
$pokemonsData = json_decode($json, true);
?>

<form action="combat.php" method="post" id="pokemons_form" class="flex flex-col gap-4 items-center">
    <div class="flex gap-10 justify-center">
        <select name="pokemon1" id="pokemon1" required
                class="ml-4 border-2 border-gray-300 rounded-lg py-2 px-10 text-gray-700">
            <?php
            foreach ($pokemonsData['types'] as $type => $pokemonsList) {
                foreach ($pokemonsList as $pokemon) {
                    echo '<option value="' . $pokemon['pokemon'] . '">' . $pokemon['pokemon'] . '</option>';
                }
            }
            ?>
        </select>
        <div class="bg-gray-300/50 rounded-lg p-2 w-fit"><p>V/S</p></div>
        <select name="pokemon2" id="pokemon2" required
                class="ml-4 border-2 border-gray-300 rounded-lg py-2 px-10 text-gray-700">
            <?php
            foreach ($pokemonsData['types'] as $type => $pokemonsList) {
                foreach ($pokemonsList as $pokemon) {
                    echo '<option value="' . $pokemon['pokemon'] . '">' . $pokemon['pokemon'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <button type="submit" value="Lancer"
            class=" bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-10 rounded focus:outline-none focus:shadow-outline w-fit">
        Lancer le combat
    </button>
</form>



</body>
</html>