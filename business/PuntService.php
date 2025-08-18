<?php 
//business/PuntService.php 
declare(strict_types = 1);

require_once("data/PuntDAO.php"); 
 
class PuntService { 
 
    public function getPuntOverzicht(): array { 
        $puntDAO = new PuntDAO(); 
        $puntenLijst = $puntDAO->getPuntenList(); 
        return $puntenLijst; 
    } 

    public function getPuntenPerModule(int $moduleId): array { 
        $puntDAO = new PuntDAO(); 
        $puntLijst = $puntDAO->getPuntenVoorModule($moduleId); 
        return $puntLijst;
        
    }

      public function haalPuntenPersoonId(int $persoonId): array { 
        $puntDAO = new PuntDAO(); 
        $punt = $puntDAO->getPuntenByPersoonId($persoonId); 
        return $punt;
        
    }
}