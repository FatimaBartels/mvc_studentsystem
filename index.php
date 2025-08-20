<?php
declare(strict_types=1);

require_once("business/ModuleService.php");
require_once("business/PersoonService.php");

$moduleSvc = new ModuleService();
$persoonSvc = new PersoonService();


$modules = $moduleSvc->getModuleOverzicht();
$studenten = $persoonSvc->getPersoonOverzicht();

$mainContent = "<h2>Selecteer een student, module of actie</h2>";


if (isset($_GET['persoonId'])) {
    ob_start();
    include("toonperpersoon.php");
    $mainContent = ob_get_clean();

} elseif (isset($_GET['moduleId'])) {
    ob_start();
    include("toonpermodule.php");
    $mainContent = ob_get_clean();

} elseif (isset($_GET['form']) && $_GET['form'] === 'addPunt') {
    ob_start();
    include("add-punt.php");
    $mainContent = ob_get_clean();
}


include("presentation/layout.php");





