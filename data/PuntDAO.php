<?php

require_once("data/DBConfig.php"); 
require_once ("entities/Punt.php");

//PuntDAO.php

class PuntDAO
{
   
    public function getPuntenList(): array
    {
        $sql = "SELECT moduleId, persoonId, punt FROM punten";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $data = $dbh->query($sql);

        $resultPunt = [];
        foreach ($data as $punt) {
                $resultPunt[] = Punt::create(
                (int)$punt['moduleId'],
                (int)$punt['persoonId'],
                (int)$punt['punt']
                
            );
        }

        $dbh = null;

        return $resultPunt;
    }
   

    public function puntToegevoegd(int $persoonId, int $moduleId): bool {
        
        $sql = "SELECT COUNT(*) FROM punten WHERE persoonId = :persoonId AND moduleId = :moduleId";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, 
                DBConfig::$DB_PASSWORD); 

        $stmt = $dbh->prepare($sql);

        $stmt->execute([':persoonId' => $persoonId, ':moduleId' => $moduleId]);

        $count = $stmt->fetchColumn();

        $dbh = null;

        return $count > 0;
    }
    


    public function addPunt(Punt $punt)
    {

        $sql = "INSERT INTO punten (moduleId, persoonId, punt)
                    VALUES (:moduleId, :persoonId, :punt)";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, 
                DBConfig::$DB_PASSWORD); 

        $stmt = $dbh->prepare($sql);
           
        $stmt->execute(
            [
                
                ':moduleId'  => $punt->getModuleId(),
                ':persoonId' => $punt->getPersoonId(),
                ':punt'      => $punt->getPunt(),    

            ]
            );
           
            $dbh = null;   

    }   
    

    public function getPuntenVoorModule(int $moduleId): array {

        $sql = "SELECT moduleId, persoonId, punt FROM punten WHERE moduleId = :moduleId";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, 
                DBConfig::$DB_PASSWORD); 

        $stmt = $dbh->prepare($sql);
        $stmt->execute([':moduleId' => $moduleId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        $punten = [];
        foreach ($result as $row) {
            $punten[] = new Punt(
                (int) $row['moduleId'],
                (int) $row['persoonId'],
                (int) $row['punt']
            );
        }

        $dbh = null;
        return $punten;
}


    public function getPuntenByPersoonId(int $persoonId): array {

        $sql ="SELECT * FROM punten WHERE persoonId = :persoonId";
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, 
                DBConfig::$DB_PASSWORD); 
    
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':persoonId' => $persoonId]);
    
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $result = [];
        foreach ($data as $punt) {
            $result[] = Punt::create(
                (int)$punt['moduleId'],
                (int)$punt['persoonId'],
                (int)$punt['punt']
               
            );
           
        }

        $dbh = null;
        return $result;
    }
    
    


}