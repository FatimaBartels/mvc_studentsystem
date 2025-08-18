<?php
declare(strict_types=1);

require_once("business/PuntService.php"); 
require_once("business/PersoonService.php"); 
/*
require_once 'PuntenDataHandler.php';
require_once 'PersonenDataHandler.php';

$puntenHandler = new PuntenDataHandler();
$persoonHandler = new PersonenDataHandler();

if (!isset($_GET['persoonId']) || !is_numeric($_GET['persoonId'])) {
    die("Ongeldig persoon ID.");
}

$persoonId = (int)$_GET['persoonId'];
$persoon = $persoonHandler->getPersoonById($persoonId);

if (!$persoon) {
    die("Student niet gevonden.");
}

$punten = $puntenHandler->getPuntenByPersoonId($persoonId);

*/
$puntenSvc = new PuntService(); 
$punten = $puntenSvc->haalPuntenPersoonId((int)$_GET['persoonId']); 

$persoonSvc = new PersoonService(); 
$persoon = $persoonSvc->haalPersoonId((int)$_GET['persoonId']); 
?>

    <link rel="stylesheet" href="css/style.css"> 

    <div >
        <h2>Student: <?= $persoon->getFamilienaam() ?> <?= $persoon->getVoornaam() ?> </h2>       
    <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Punt</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($punten as $punt): ?>
                   
                    
                    <tr>
                        <td><?= $punt->getModule()->getNaam() ?></td>
                        <td><?= $punt->getPunt() ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    
    </div>
