<?php

session_start();

require_once "class/Pokemon.php";
require_once "class/Capacite.php";
require_once "class/Combat.php";

if (!isset($_POST["action"]) || empty($_POST["action"])) {
    die("Action non définie");
}

if (!isset($_SESSION["pokemon1"]) || !isset($_SESSION["pokemon2"])) {
    die("Pokemons non définis");
}

$pokemon1 = unserialize($_SESSION["pokemon1"]);
$pokemon2 = unserialize($_SESSION["pokemon2"]);

if (isset($_SESSION["combat"])) {
    $combat = unserialize($_SESSION["combat"]);
} else {
    $combat = new Combat($pokemon1, $pokemon2);
    $combat->demarrerCombat();
}

if ($_POST["action"] == "attaque") {
    $attaquant = $_POST["attaquant"];
    $defenseur = $_POST["defenseur"];
    $special = $_POST["special"] == "true";

    $combat->tourDeCombat($attaquant, $defenseur, $special);

    $_SESSION["pokemon1"] = serialize($pokemon1);
    $_SESSION["pokemon2"] = serialize($pokemon2);
    $_SESSION["combat"] = serialize($combat);
} else {
    die("Action non reconnue");
}

?>