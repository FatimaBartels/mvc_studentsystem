<?php 

//business/PersoonService.php 
declare(strict_types = 1);

require_once("data/PersoonDAO.php"); 
 
class PersoonService { 
 
    public function getPersoonOverzicht(): array { 
        $persoonDAO = new PersoonDAO(); 
        return $persoonDAO->getPersonenList(); 
       
    } 

    public function getPersoonId(int $id): Persoon { 
        $persoonDAO = new PersoonDAO(); 
        return $persoonDAO->getPersoonById($id); 
      
    } 


}