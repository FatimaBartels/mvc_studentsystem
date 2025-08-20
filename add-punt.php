<?php
declare(strict_types=1);

session_start();

require_once("business/PuntService.php");
require_once("exceptions/PuntBestaatAlException.php");
require_once("exceptions/OngeldigPuntException.php");

if (isset($_GET["action"]) && $_GET["action"] === "process") {
    $persoonId = (int)$_POST['persoonId'];
    $moduleId  = (int)$_POST['moduleId'];
    $punt      = (int)$_POST['punt'];

    try {
        $puntSvc = new PuntService();
        $puntSvc->voegPuntToe($persoonId, $moduleId, $punt);

        $_SESSION['success'] = "Punt is toegevoegd.";
    } catch (PuntBestaatAlException $e) {
        $_SESSION['error'] = $e->getMessage();
    } catch (OngeldigPuntException $e) {
        $_SESSION['error'] = $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = "Onverwachte fout: " . $e->getMessage();
    }

    header("Location: index.php?form=addPunt");
    exit;
}


require_once("business/ModuleService.php");
require_once("business/PersoonService.php");

$moduleSvc = new ModuleService();
$persoonSvc = new PersoonService();


$modules = $moduleSvc->getModuleOverzicht(); 
$personen = $persoonSvc->getPersoonOverzicht();

include("presentation/punt-form.php");
