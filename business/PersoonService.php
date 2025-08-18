<?php 
//business/PersoonService.php 
declare(strict_types = 1);

require_once("data/PersoonDAO.php"); 
 
class PersoonService { 
 
    public function getPersoonOverzicht(): array { 
        $persoonDAO = new PersoonDAO(); 
        $personen = $persoonDAO->getPersonenList(); 
        return $personen; 
    } 

}