<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once './class/Pokemon.php';
require_once './class/Attaque.php';
require_once './class/Capacite.php';
require_once './class/Combat.php';

if (isset($_POST['pokemon1']) && isset($_POST['pokemon2'])) {
    $getPokemon1 = $_POST['pokemon1'];
    $getPokemon2 = $_POST['pokemon2'];

    $_SESSION['pokemon1_index'] = $getPokemon1;
    $_SESSION['pokemon2_index'] = $getPokemon2;
}

$json = file_get_contents('./pokemons.json');
$pokemonsData = json_decode($json, true);

if (!isset($_SESSION['pokemon1']) || !isset($_SESSION['pokemon2'])) {
    $pokemon1Data = $pokemonsData['pokemons'][$_SESSION['pokemon1_index']];
    $pokemon2Data = $pokemonsData['pokemons'][$_SESSION['pokemon2_index']];

    $_SESSION['pokemon1number'] = $pokemon1Data['numero'];
    $_SESSION['pokemon2number'] = $pokemon2Data['numero'];

    $attaqueNormale1 = $pokemon1Data['attaques'][0];
    $attaqueNormale2 = $pokemon2Data['attaques'][0];

    $capacite1 = new Capacite(
        $attaqueNormale1["nom"],
        $attaqueNormale1["degats"],
        $attaqueNormale1["precision"],
        $pokemon1Data['type']
    );

    $capacite2 = new Capacite(
        $attaqueNormale2["nom"],
        $attaqueNormale2["degats"],
        $attaqueNormale2["precision"],
        $pokemon2Data['type']
    );

    $pokemon1 = match ($pokemon1Data['type']) {
        'eau' => new PokemonEau($pokemon1Data['nom'], 500, 100, $pokemon1Data['defense'], $capacite1),
        'feu' => new PokemonFeu($pokemon1Data['nom'], 500, 100, $pokemon1Data['defense'], $capacite1),
        'plante' => new PokemonPlante($pokemon1Data['nom'], 500, 100, $pokemon1Data['defense'], $capacite1),
    };

    $pokemon2 = match ($pokemon2Data['type']) {
        'eau' => new PokemonEau($pokemon2Data['nom'], 500, 100, $pokemon2Data['defense'], $capacite2),
        'feu' => new PokemonFeu($pokemon2Data['nom'], 500, 100, $pokemon2Data['defense'], $capacite2),
        'plante' => new PokemonPlante($pokemon2Data['nom'], 500, 100, $pokemon2Data['defense'], $capacite2),
    };
} else {
    $pokemon1 = unserialize($_SESSION['pokemon1']);
    $pokemon2 = unserialize($_SESSION['pokemon2']);
    if (isset($_SESSION['combat'])) {
        $combat = unserialize($_SESSION['combat']);
    }
}

$_SESSION['pokemon1'] = serialize($pokemon1);
$_SESSION['pokemon2'] = serialize($pokemon2);

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

        <h1 class="text-3xl font-medium text-center">C'est l'heure de<br /><span class="font-bold">Combattre <img
                    src="assets/pokeball.svg"
                    alt="Pokeball" class="inline-block w-6 h-6"></span>
        </h1>
    </div>

    <div class="flex gap-10 items-center">
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?php echo $_SESSION["pokemon1number"] ?>.png" alt="Pokemon 1" class="inline-block w-52 h-52">
        <div class="bg-gray-300/50 rounded-lg p-4 w-fit">
            <p>V/S</p>
        </div>
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?php echo $_SESSION["pokemon2number"] ?>.png" alt=" Pokemon 2" class="inline-block w-52 h-52">
    </div>

    <div class="flex justify-around w-full gap-4">
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-bold">Joueur 1</h2>
            <div class="flex gap-1">
                <div class="flex flex-col gap-1 w-full">
                    <?php
                    echo "<p>" . $pokemon1->getNom() . "</p>";
                    echo "<div class='w-full bg-gray-300 rounded-full h-6 overflow-hidden p-1'>
                        <div class='bg-blue-400 h-full text-center text-white rounded-full' style='width: " . ($pokemon1->getPointsDeVie() / 500 * 100) . "%;'>
                            " . $pokemon1->getPointsDeVie() . "/500
                        </div>
                    </div>";
                    ?>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p>Choisis ton attaque</p>
                <ul class="flex gap-2 items-center">
                    <?php

                    echo "<li>
                            <form action='traitement.php' method='post'>
                                <input type='hidden' name='action' value='attaque'>
                                <input type='hidden' name='attaquant' value='1'>
                                <input type='hidden' name='defenseur' value='2'>
                                <input type='hidden' name='special' value='false'>
                                <button type='submit' name='pokemon1' class='bg-[#222] text-white rounded-lg py-2 px-4 w-fit'>"
                        . $pokemon1->getCapaciteNormale()->getNom()
                        . " (Dégâts: " . $pokemon1->getCapaciteNormale()->getDegats()
                        . ", Précision: " . $pokemon1->getCapaciteNormale()->getPrecision() . ")</button>
                            </form>
                        </li>";

                    echo "<li>
                        <form action='traitement.php' method='post'>
                            <input type='hidden' name='action' value='attaque'>
                            <input type='hidden' name='attaquant' value='1'>
                            <input type='hidden' name='defenseur' value='2'>
                            <input type='hidden' name='special' value='true'>
                            <button type='submit' name='pokemon1' class='bg-[#DDF3FF] border-2 border-[#00AFED] text-[#00AFED] font-bold rounded-lg py-2 px-4 w-fit'>"
                        . $pokemon1->getCapaciteSpeciale() . "</button>
                        </form>
                    </li>";
                    ?>
                    <li>
                        <form action="traitement.php" method="post">
                            <input type="hidden" name="action" value="soin">
                            <input type="hidden" name="cible" value="1">
                            <button type="submit" class="bg-[#00FF00] text-white rounded-lg py-2 px-4 w-fit">Soigner</button>
                        </form>
                    </li>
                </ul>

            </div>
        </div>

        <div class="flex flex-col gap-2 h-full justify-end">
            <?php if (isset($combat) && $combat->getVainqueur() != 0): ?>
                <h2 class="text-2xl font-bold">Le joueur <?php echo $combat->getVainqueur(); ?> a gagné !</h2>
            <?php elseif (isset($combat) && $combat->getVainqueur() == 0): ?>
                <h2 class="text-2xl font-bold">Tour du joueur <?php echo $combat->getTurn() ?></h2>
            <?php else: ?>
                <h2 class="text-2xl font-bold">Tour du joueur 1</h2>
            <?php endif; ?>
            <button type="button" id="quitter"
                class="bg-red-500 hover:bg-red-700 h-fit text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200"
                ick="window.location.href='destroy.php'">Quitter
            </button>
            <?php if (isset($combat) && $combat->getVainqueur() != 0): ?>
                <script>
                    document.getElementById('quitter').innerText = 'Rejouer';
                </script>
            <?php endif; ?>

        </div>

        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-bold">Joueur 2</h2>
            <div class="flex gap-1">
                <div class="flex flex-col gap-1 w-full">
                    <?php
                    echo "<p>" . $pokemon2->getNom() . "</p>";
                    echo "<div class='w-full bg-gray-300 rounded-full h-6 overflow-hidden p-1'>
                        <div class='bg-red-400 h-full text-center text-white rounded-full' style='width: " . ($pokemon2->getPointsDeVie() / 500 * 100) . "%;'>
                            " . $pokemon2->getPointsDeVie() . "/500
                        </div>
                    </div>";
                    ?>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p>Choisis ton attaque</p>
                <ul class="flex gap-2 items-center">
                    <?php
                    echo "<li>
                            <form action='traitement.php' method='post'>
                                <input type='hidden' name='action' value='attaque'>
                                <input type='hidden' name='attaquant' value='2'>
                                <input type='hidden' name='defenseur' value='1'>
                                <input type='hidden' name='special' value='false'>
                                <button type='submit' name='pokemon2' class='bg-[#222] text-white rounded-lg py-2 px-4 w-fit'>"
                        . $pokemon2->getCapaciteNormale()->getNom()
                        . " (Dégâts: " . $pokemon2->getCapaciteNormale()->getDegats()
                        . ", Précision: " . $pokemon2->getCapaciteNormale()->getPrecision() . ")</button>
                            </form>
                        </li>";
                    echo "<li>
                        <form action='traitement.php' method='post'>
                            <input type='hidden' name='action' value='attaque'>
                            <input type='hidden' name='attaquant' value='2'>
                            <input type='hidden' name='defenseur' value='1'>
                            <input type='hidden' name='special' value='true'>
                            <button type='submit' name='pokemon2' class='bg-[#FFF4DD] border-2 border-[#FFB552] text-[#FFB552] font-bold rounded-lg py-2 px-4 w-fit'>"
                        . $pokemon2->getCapaciteSpeciale() . "</button>
                        </form>
                    </li>";
                    ?>
                    <form action="traitement.php" method="post">
                        <input type="hidden" name="action" value="soin">
                        <input type="hidden" name="cible" value="2">
                        <button type="submit" class="bg-[#00FF00] text-white rounded-lg py-2 px-4 w-fit">Soigner</button>
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <?php if (isset($combat) && $combat->getVainqueur() != 0): ?>
        <script>
            const buttons = document.querySelectorAll('button:not(#quitter)');
            buttons.forEach(button => {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
            });
        </script>
    <?php endif; ?>
</body>

</html>