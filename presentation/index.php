<?php 

declare(strict_types=1); 

$mainContent = "<h2>Selecteer een student, module of actie</h2>";

if (isset($_GET['persoonId'])) {
    ob_start();
    include 'punten-per-persoon.php';
    $mainContent = ob_get_clean();
} elseif (isset($_GET['moduleId'])) {
    ob_start();
    include 'punten-per-module.php';
    $mainContent = ob_get_clean();
} elseif (isset($_GET['form']) && $_GET['form'] === 'addPunt') {
    ob_start();
    include 'punt-form.php';
    $mainContent = ob_get_clean();
}


?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="presentation/css/style.css">

  <title>Studenten Systeem</title>
</head>
<body>
<div class="container">

  <div class="sidebar">
    <h2>STUDENTEN</h2>
    <ul>
      <?php foreach ($studenten as $student): ?>
        <li>
          <a href="?persoonId=<?= $student->getId() ?>">
            <?= $student->getVoornaam() . ' ' . $student->getFamilienaam() ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <h2>MODULES</h2>
    <ul>
      <?php foreach ($modules as $module): ?>
        <li>
          <a href="?moduleId=<?= $module->getId() ?>">
            <?= $module->getNaam() ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <h2>ACTIES</h2>
    <ul>
      <li><a href="?form=addPunt">Punt toevoegen</a></li>
    </ul>
  </div>

  <div class="content" id="main-content">
    <div class="card">

      <?= $mainContent ?>

    </div>
  </div>

</div>
</body>
</html>


