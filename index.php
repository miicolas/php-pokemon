<?php

require_once './class/Pokemon.php';
require_once './class/Attaque.php';

?>

<Doctype html>
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
        $pokemons = json_decode($json, true);

        foreach ($pokemons['types'] as $type => $pokemons) {
            echo '<h2 class="text-2xl font-bold underline">' . $type . '</h2>';
            foreach ($pokemons as $pokemon) {
                echo '<h3 class="text-xl font-bold underline">' . $pokemon['pokemon'] . '</h3>';
                echo '<ul>';
                foreach ($pokemon['attaques'] as $attaque) {
                    echo '<li>' . $attaque['nom'] . ' : ' . $attaque['degats'] . ' / ' . $attaque['precision'] . '</li>';
                }
                echo '</ul>';
            }
        }







        $pokemon = new PokemonFeu('Salamèche', 39,10 , 2);
        echo '<h2>'. $pokemon->getNom() .'</h2>';
        echo '<p>Points de vie : '. $pokemon->getPointsDeVie() .'</p>';
        echo '<p>Capacité spéciale : '. $pokemon->getNomCapaciteSpeciale() .'</p>';
        $pokemon2 = new PokemonPlante('Bulbizarre', 45, 4, 1);
        echo '<h2>'. $pokemon2->getNom() .'</h2>';
        $attaque = new Attaque('Lance-Flammes', 90, 100);

        echo '<p> Pokemon 1 attaque Pokemon 2</p>';
        echo '<p> Pokemon 2 a '. $pokemon2->getPointsDeVie() .'</p>';
        $pokemon->capaciteSpeciale($pokemon2);
        echo '<p>Points de vie : '. $pokemon2->getPointsDeVie() .'</p>';



        ?>

    </body>
</html>