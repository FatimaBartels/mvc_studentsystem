<?php
declare(strict_types=1);


?>

<link rel="stylesheet" href="presentation/css/style.css">
<div>
    <h2>Module: <?= $module->getNaam(); ?>
    </h2>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Punt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($punten as $punt): ?> 
                    <tr>
                        <td><?= $punt->getPersoon()->getFamilienaam() ?> <?= $punt->getPersoon()->getVoornaam() ?> </td>
                        <td><?= $punt->getPunt() ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
