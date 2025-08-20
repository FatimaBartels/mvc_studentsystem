<?php

require_once("data/DBConfig.php"); 
//require_once ("entities/Punt.php");
//require_once("data/PersoonDAO.php");
//require_once("data/ModuleDAO.php");

//PuntDAO.php

class PuntDAO
{
   
    public function getPuntenList(): array
    {   
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT p.punt,
                    pers.id AS persoonId, pers.familienaam, pers.voornaam, pers.geslacht,
                    m.id AS moduleId, m.naam AS moduleNaam
                FROM punten p
                JOIN personen pers ON p.persoonId = pers.id
                JOIN modules m ON p.moduleId = m.id";

        $data = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return $data;

       
        /*
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

        return $resultPunt;*/
    }
   
      public function getByPersoonId(int $persoonId): array
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT p.punt,
                    pers.id AS persoonId, pers.familienaam, pers.voornaam, pers.geslacht,
                    m.id AS moduleId, m.naam AS moduleNaam
                FROM punten p
                JOIN personen pers ON p.persoonId = pers.id
                JOIN modules m ON p.moduleId = m.id
                WHERE pers.id = :persoonId";

        $stmt = $dbh->prepare($sql);
        $stmt->execute([':persoonId' => $persoonId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return $data;
    }

    
    public function puntToegevoegd(int $persoonId, int $moduleId): bool {
            
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(*) FROM punten WHERE persoonId = :persoonId AND moduleId = :moduleId";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':persoonId' => $persoonId, ':moduleId' => $moduleId]);
        $count = $stmt->fetchColumn();

        $dbh = null;
        return $count > 0;
    }
    


    public function create(int $persoonId, int $moduleId, int $punt): void
    {
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO punten (moduleId, persoonId, punt) VALUES (:moduleId, :persoonId, :punt)";

        $stmt = $dbh->prepare($sql);
           
        $stmt->execute(
            [
                
                ':moduleId'  => $moduleId,
                ':persoonId' => $persoonId,
                ':punt'      => $punt,    

            ]
            );
           
            $dbh = null;   

    }   
    

    public function getPuntenVoorModule(int $moduleId): array 
    {

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT p.punt,
                    pers.id AS persoonId, pers.familienaam, pers.voornaam, pers.geslacht,
                    m.id AS moduleId, m.naam AS moduleNaam
                FROM punten p
                JOIN personen pers ON p.persoonId = pers.id
                JOIN modules m ON p.moduleId = m.id
                WHERE m.id = :moduleId
                ORDER BY pers.familienaam, pers.voornaam";

        $stmt = $dbh->prepare($sql);
        $stmt->execute([':moduleId' => $moduleId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dbh = null;

        return $result;
       
}


    public function getPuntenByPersoon(int $persoonId): array {
        $sql = "SELECT * FROM punten WHERE persoonId = :persoonId";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":persoonId" => $persoonId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;

    $result = [];
    foreach ($rows as $row) {
        $persoonDAO = new PersoonDAO();
        $moduleDAO  = new ModuleDAO();
        $persoon    = $persoonDAO->getPersoonById((int)$row["persoonId"]);
        $module     = $moduleDAO->getModuleById((int)$row["moduleId"]);

        $result[] = new Punt( $persoon, $module, (int)$row["punt"]);
    }

    return $result;
}
    


}