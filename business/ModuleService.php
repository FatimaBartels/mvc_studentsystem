<?php 
//business/ModuleService.php 
declare(strict_types = 1);

require_once("data/ModuleDAO.php"); 
 
class ModuleService { 
 
    public function getModuleOverzicht(): array { 
        $moduleDAO = new ModuleDAO(); 
        return $moduleDAO->getModulesList(); 
        
    } 

    public function getModuleId(int $id) : ?Module {
        $moduleDAO =  new ModuleDAO();
        return $moduleDAO->getModuleById($id);
        
    }

}