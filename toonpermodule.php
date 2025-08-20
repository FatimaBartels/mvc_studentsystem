<?php

declare(strict_types=1);

require_once("business/ModuleService.php");
require_once("business/PuntService.php");

$moduleSvc = new ModuleService();
$puntSvc = new PuntService();

if (!isset($_GET['moduleId']) || !is_numeric($_GET['moduleId'])) {
    die("Ongeldig module ID.");
}

$moduleId = (int)$_GET['moduleId'];

// Get module details
$module = $moduleSvc->getModuleId($moduleId);
if (!$module) {
    die("Module niet gevonden.");
}

// Get punten for this module
$punten = $puntSvc->getPuntenPerModule($moduleId);


include("presentation/punten-per-module.php");
