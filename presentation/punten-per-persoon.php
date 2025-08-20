<?php
declare(strict_types=1);


?>

<link rel="stylesheet" href="presentation/css/style.css">
<div>
    <h2>Student: <?= $persoon->getFamilienaam() ?> <?= $persoon->getVoornaam() ?></h2>
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