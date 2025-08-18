<?php 
//overzicht.php 
declare(strict_types = 1); 

require_once("business/ModuleService.php"); 
require_once("business/PersoonService.php"); 

$moduleSvc = new ModuleService(); 
$modules = $moduleSvc->getModuleOverzicht(); 

$persoonSvc = new PersoonService(); 
$studenten = $persoonSvc->getPersoonOverzicht(); 

include("presentation/index.php"); 