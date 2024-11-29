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
    <h1 class="text-3xl font-bold text-center">
        Sélectionne tes <br/>
        <span>Pokemons
                <img src="./assets/pokeball.svg" alt="Pokeball" class="inline-block w-6 h-6">
            </span>
    </h1>
</div>

<?php
$json = file_get_contents('./pokemons.json');
$pokemonsData = json_decode($json, true);
?>

<form action="combat.php" method="post" id="pokemons_form" class="flex flex-col gap-4 items-center">
    <div class="flex gap-10 justify-center items-center">
        <select name="pokemon1" id="pokemon1" required class="appearance-none bg-white text-gray-800 w-48 px-4 py-2 rounded-lg border-2 border-gray-300 focus:outline-none focus:border-blue-500">
            <option value="" disabled selected>Choisir Pokémon 1</option>
            <?php
            foreach ($pokemonsData['pokemons'] as $key => $pokemon) {
                echo '<option value="' . htmlspecialchars($key) . '">' . htmlspecialchars($pokemon['nom']) . '</option>';
            }
            ?>
        </select>

        <div class="bg-gray-300/50 rounded-lg p-2 w-fit">
            <p>V/S</p>
        </div>

        <select name="pokemon2" id="pokemon2" required class="appearance-none bg-white text-gray-800 w-48 px-4 py-2 rounded-lg border-2 border-gray-300 focus:outline-none focus:border-blue-500">
            <option value="" disabled selected>Choisir Pokémon 2</option>
            <?php
            foreach ($pokemonsData['pokemons'] as $key => $pokemon) {
                echo '<option value="' . htmlspecialchars($key) . '">' . htmlspecialchars($pokemon['nom']) . '</option>';
            }
            ?>
        </select>
    </div>

    <button type="submit" class="mt-6 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-10 rounded-lg focus:outline-none focus:shadow-outline transition duration-200">
        Lancer le combat
    </button>
</form>
</body>
</html>