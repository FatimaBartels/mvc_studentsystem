<?php

// Class Punt.php

declare(strict_types = 1);

require_once("entities/Persoon.php") ;
require_once("entities/Module.php") ;



class Punt
{
    private static $idMap = array();
    private ?int $moduleId;
    private ?int $persoonId;
    private ?int $punt;

    

    public function __construct(?int $moduleId, ?int $persoonId, ?int $punt)
    {
        $this->moduleId    = $moduleId;
        $this->persoonId= $persoonId;
        $this->punt  = $punt;
       
       
       
    }

    public static function create(int $moduleId, int $persoonId, int $punt
        )

    {
         if (!isset(self::$idMap[$moduleId])) {
         self::$idMap[$moduleId] =  new Punt($moduleId, $persoonId, $punt);
    }

    return self::$idMap[$moduleId];
}

    

    public function getModuleId(): ?int
    {
        return $this->moduleId;
    }

    public function getPersoonId(): ?int
    {
        return $this->persoonId;
    }

    public function getPunt(): ?int
    {
        return $this->punt;
    }


   public function getPersoon() {
    
    $this->connect();

  
    $stmt = $this->dbh->prepare("SELECT * FROM personen WHERE id = :id");

    $stmt->execute([':id' => $this->persoonId]);

    $persoonResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$persoonResult) {
        $this->disconnect();
        return new Persoon("Onbekend", "Onbekend", "X", 0);
    }

    $persoon = new Persoon(
    $persoonResult["familienaam"],
    $persoonResult["voornaam"], 
    $persoonResult["geslacht"],
    (int)$persoonResult["id"]
    
    );

    $this->disconnect();
    return $persoon;
    }
     
    
    public function getModule() {

        $this->connect();

        $stmt = $this->dbh->prepare("SELECT * FROM modules WHERE id = :id");
    
        $stmt->execute([':id' => $this->moduleId]);

        $moduleResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$moduleResult) {
        $this->disconnect();
        return new Module(0, "Onbekend");
    }

      
        $module = new Module(
        $moduleResult["id"],
        $moduleResult["naam"]
        
        );

        $this->disconnect();

        return $module;
    }

    private function connect()
    {
        $this->dbh = new PDO(
            "mysql:host=localhost;port=3307;dbname=cursusphp;charset=utf8",
            "root",
            ''
        );
    }

    private function disconnect()
    {
        $this->dbh = null;
    }


}
