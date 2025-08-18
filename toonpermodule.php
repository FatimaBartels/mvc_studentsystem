<?php 
//overzicht.php 
declare(strict_types = 1); 


require_once("business/ModuleService.php"); 
require_once("business/PuntService.php"); 



if (!isset($_GET['moduleId']) || !is_numeric($_GET['moduleId'])) {
    die("Ongeldig module ID.");
}

$moduleSvc = new ModuleService();
$module = $moduleSvc->getModuleId((int)$_GET['moduleId']); 


if (!$module) {
    die("Module niet gevonden.");
}


$puntSvc = new PuntService(); 
$punten = $puntSvc->getPuntenPerModule($id); 

include("presentation/index.php"); 