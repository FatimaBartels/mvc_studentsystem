<?php
declare(strict_types=1);

require_once("business/PuntService.php");
require_once("business/PersoonService.php");

$persoonSvc = new PersoonService();
$puntSvc    = new PuntService();

if (!isset($_GET['persoonId']) || !is_numeric($_GET['persoonId'])) {
    die("Ongeldig student ID.");
}

$persoonId = (int)$_GET['persoonId'];

$persoon = $persoonSvc->getPersoonId($persoonId);

if (!$persoon) {
    die("Student niet gevonden.");
}

// Gebruik de nieuwe functie in PuntService
$punten = $puntSvc->getPuntenPerPersoon($persoonId);

//ob_start();
include("presentation/punten-per-persoon.php");
//$mainContent = ob_get_clean();
