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

