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
<h1 class="text-3xl font-bold underline">Pokemons</h1>

<?php
$json = file_get_contents('./pokemons.json');
$pokemonsData = json_decode($json, true);

foreach ($pokemonsData['types'] as $type => $pokemonsList) {
    echo '<h2 class="text-2xl font-bold underline">' . $type . '</h2>';
    foreach ($pokemonsList as $pokemon) {
        echo '<h3 class="text-xl font-bold underline">' . $pokemon['pokemon'] . '</h3>';
        echo '<ul>';
        foreach ($pokemon['attaques'] as $attaque) {
            echo '<li>' . $attaque['nom'] . ' : ' . $attaque['degats'] . ' / ' . $attaque['precision'] . '</li>';
        }
        echo '</ul>';
    }
}

$pokemon = new PokemonFeu('Salamèche', 39, 10, 2);
echo '<h2>' . $pokemon->getNom() . '</h2>';
echo '<p>Points de vie : ' . $pokemon->getPointsDeVie() . '</p>';
echo '<p>Capacité spéciale : ' . $pokemon->getNomCapaciteSpeciale() . '</p>';

$pokemon2 = new PokemonPlante('Bulbizarre', 45, 4, 1);
echo '<h2>' . $pokemon2->getNom() . '</h2>';
$attaque = new Attaque('Lance-Flammes', 90, 100);

echo '<p>Pokemon 1 attaque Pokemon 2</p>';
echo '<p>Pokemon 2 a ' . $pokemon2->getPointsDeVie() . '</p>';
$pokemon->capaciteSpeciale($pokemon2);
echo '<p>Points de vie : ' . $pokemon2->getPointsDeVie() . '</p>';

?>

<form action="combat.php" method="post" id="pokemons_form">
    <select name="pokemon1" required class="ml-4 border-2 border-gray-300 rounded-lg py-2 px-4">
        <?php
        foreach ($pokemonsData['types'] as $type => $pokemonsList) {
            foreach ($pokemonsList as $pokemon) {
                echo '<option value="' . $pokemon['pokemon'] . '">' . $pokemon['pokemon'] . '</option>';
            }
        }
        ?>
    </select>
    <select name="pokemon2" required class="ml-4 border-2 border-gray-300 rounded-lg py-2 px-4">
        <?php
        foreach ($pokemonsData['types'] as $type => $pokemonsList) {
            foreach ($pokemonsList as $pokemon) {
                echo '<option value="' . $pokemon['pokemon'] . '">' . $pokemon['pokemon'] . '</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Lancer" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
</form>
</body>
</html>
