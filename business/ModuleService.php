<?php 
//business/ModuleService.php 
declare(strict_types = 1);

require_once("data/ModuleDAO.php"); 
 
class ModuleService { 
 
    public function getModuleOverzicht(): array { 
        $moduleDAO = new ModuleDAO(); 
        $modules = $moduleDAO->getModulesList();; 
        return $modules; 
    } 

}