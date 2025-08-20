<?php
declare(strict_types = 1); 

require_once("data/DBConfig.php"); 
require_once("entities/Module.php");

class ModuleDAO
{
   
    public function getModulesList(): Array {

        $sql = "SELECT id, naam FROM modules";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        
        $data = $dbh->query($sql);


        $resultModule = [];
        foreach ($data as $row) {
           $resultModule[] = Module::create(
                (int)$row['id'], 
                $row['naam']);
        }

        $dbh = null; 

        return $resultModule;
    }


    public function getModuleById(int $id): ?Module {

        $sql = "SELECT * FROM modules WHERE id = :id";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
     
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':id' => $id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
    
        if (!$row) {
            return null;
        }

        return new Module((int)$row['id'], $row['naam']);
        
        
    }

     

}