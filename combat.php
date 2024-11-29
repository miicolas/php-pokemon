<?php

require_once './class/Pokemon.php';
require_once './class/Attaque.php';
require_once './class/Capacite.php';

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
    <h1 class="text-3xl font-medium text-center">C'est l'heure de<br/><span class="font-bold">Combattre <img
                    src="assets/pokeball.svg"
                    alt="Pokeball" class="inline-block w-6 h-6"></span>
    </h1>
</div>

<div class="flex gap-10 items-center">
    <img src="./assets/tortank.png" alt="Pokemon 1" class="inline-block w-52 h-52">
    <div class="bg-gray-300/50 rounded-lg p-4 w-fit"><p>V/S</p></div>
    <img src="./assets/drakofeu.png" alt="Pokemon 2" class="inline-block w-52 h-52">
</div>

<?php

$getPokemon1 = $_POST['pokemon1'];
$getPokemon2 = $_POST['pokemon2'];

session_start();



echo $getPokemon1;
echo $getPokemon2;

$json = file_get_contents('./pokemons.json');
$pokemonsData = json_decode($json, true);

// cherche le type de pokemon 1 et 2 dans le json
$pokemon1Data = $pokemonsData['pokemons'][$getPokemon1];
$pokemon2Data = $pokemonsData['pokemons'][$getPokemon2];

$pokemon1 = null;
$pokemon2 = null;

$attaqueNormale1 = $pokemon1Data['attaques'][0];
$capacite1 = new Capacite($attaqueNormale1["nom"], $attaqueNormale1["degats"], $attaqueNormale1["precision"], $pokemon1Data['type']);

$attaqueNormale2 = $pokemon2Data['attaques'][0];
$capacite2 = new Capacite($attaqueNormale2["nom"], $attaqueNormale2["degats"], $attaqueNormale2["precision"], $pokemon2Data['type']);

if ($pokemon1Data['type'] === 'eau') {
    $pokemon1 = new PokemonEau(nom: $pokemon1Data['nom'], pointsDeVie: 500, pointsAttaque: 100, defense: $pokemon1Data['defense'], capacite: $capacite1);
} elseif ($pokemon1Data['type'] === 'feu') {
    $pokemon1 = new PokemonFeu(nom: $pokemon1Data['nom'], pointsDeVie: 500, pointsAttaque: 100, defense: $pokemon1Data['defense'], capacite: $capacite1);
} elseif ($pokemon1Data['type'] === 'plante') {
    $pokemon1 = new PokemonPlante(nom: $pokemon1Data['nom'], pointsDeVie: 500, pointsAttaque: 100, defense: $pokemon1Data['defense'], capacite: $capacite1);
}

if ($pokemon2Data['type'] === 'eau') {
    $pokemon2 = new PokemonEau(nom: $pokemon2Data['nom'], pointsDeVie: 500, pointsAttaque: 100, defense: $pokemon2Data['defense'], capacite: $capacite2);
} elseif ($pokemon2Data['type'] === 'feu') {
    $pokemon2 = new PokemonFeu(nom: $pokemon2Data['nom'], pointsDeVie: 500, pointsAttaque: 100, defense: $pokemon2Data['defense'], capacite: $capacite2);
} elseif ($pokemon2Data['type'] === 'plante') {
    $pokemon2 = new PokemonPlante(nom: $pokemon2Data['nom'], pointsDeVie: 500, pointsAttaque: 100, defense: $pokemon2Data['defense'], capacite: $capacite2);
}

$_SESSION['pokemon1'] = serialize($pokemon1);
$_SESSION['pokemon2'] = serialize($pokemon2);

?>

<div class="flex flex-col gap-4">
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl font-bold">Joueur 1</h2>
        <div class="flex gap-1">
            <div class="flex gap-1">
                <?php
                echo "<p>" . $pokemon1->getNom() . "</p>";
                echo "<p>" . $pokemon1->getPointsDeVie() . "/500</p>";
                ?>
            </div>
        </div>
        <div class="flex gap-1">
            <p>Attaques:</p>
            <form action="traitement.php" method="post" id="pokemons_form" class="flex flex-col gap-4 items-center">

                <ul>

                    <?php
                    foreach ($pokemon1Data['attaques'] as $attaque) {
                        echo "<li><button type='submit' name='pokemon2'>" . htmlspecialchars($attaque['nom']) . " (Dégâts: " . htmlspecialchars($attaque['degats']) . ", Précision: " . htmlspecialchars($attaque['precision']) . ")</button></li>";
                    }
                    ?>
                </ul>
            </form>
        </div>
    </div>
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl font-bold">Joueur 2</h2>
        <div class="flex gap-1">
            <div class="flex gap-1">
                <?php
                echo "<p>" . $pokemon2->getNom() . "</p>";
                echo "<p>" . $pokemon2->getPointsDeVie() . "/500</p>";
                ?>
            </div>
        </div>
        <div class="flex gap-1">
            <p>Attaques:</p>
            <form action="traitement.php" method="post" id="pokemons_form" class="flex flex-col gap-4 items-center">

                <ul>

                    <?php
                    foreach ($pokemon2Data['attaques'] as $attaque) {
                        echo "<li><input type='hidden' name='action' value='attaque'><input type='hidden' name='attaquant' value='2'><input type='hidden' name='defenseur' value='1'> <input type='hidden' name='special' value='false'><button type='submit' name='pokemon2'>" . htmlspecialchars($attaque['nom']) . " (Dégâts: " . htmlspecialchars($attaque['degats']) . ", Précision: " . htmlspecialchars($attaque['precision']) . ")</button></li>";
                    }

                    echo "<li><input type='hidden' name='action' value='attaque'><input type='hidden' name='attaquant' value='2'><input type='hidden' name='defenseur' value='1'> <input type='hidden' name='special' value='true'><button type='submit' name='pokemon2'>" . $pokemon2->getCapaciteSpeciale() . "</button></li>";
                    ?>

                </ul>
            </form>
        </div>
    </div>
</div>

</body>
</html>