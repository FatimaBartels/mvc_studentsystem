<?php
declare(strict_types=1);

require_once("business/PuntService.php"); 
require_once("business/PersoonService.php"); 
/*


$puntenHandler = new PuntenDataHandler();
$persoonHandler = new PersonenDataHandler();

if (!isset($_GET['persoonId']) || !is_numeric($_GET['persoonId'])) {
    die("Ongeldig persoon ID.");
}

$persoonId = (int)$_GET['persoonId'];
$persoon = $persoonHandler->haalPersoonId($persoonId);

if (!$persoon) {
    die("Student niet gevonden.");
}

$punten = $puntenHandler->getPuntenByPersoonId($persoonId);


*/

$puntenSvc = new PuntService(); 
$punten = $puntenSvc->haalPuntenPersoonId((int)$_GET['persoonId']); 

$persoonSvc = new PersoonService(); 
$persoon = $persoonSvc->haalPersoonId((int)$_GET['persoonId']); 

//include("presentation/punten-per-persoon.php"); 
?>