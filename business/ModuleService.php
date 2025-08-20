<?php 
//business/ModuleService.php 
declare(strict_types = 1);

require_once("data/ModuleDAO.php"); 
 
class ModuleService { 
 
    public function getModuleOverzicht(): array { 
        $moduleDAO = new ModuleDAO(); 
        $modules = $moduleDAO->getModulesList(); 
        return $modules; 
    } 

    public function getModuleId(int $id) : ?Module {
        $moduleDAO =  new ModuleDAO();
        return $moduleDAO->getModuleById($id);
        
    }

}