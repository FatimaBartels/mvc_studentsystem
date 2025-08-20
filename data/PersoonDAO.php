<?php

require_once("data/DBConfig.php"); 
require_once( "entities/Persoon.php");

class PersoonDAO
{
   
    
    public function getPersonenList(): array
    {
     
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM personen";

        $data = $dbh->query($sql);
       

        $resultPersoon = [];
        foreach ($data as $persoon) {
            $resultPersoon [] = Persoon::create(
                (int)$persoon['id'],
                $persoon['familienaam'],
                $persoon['voornaam'],
                $persoon['geslacht']
                
            );
        }

        $dbh = null;

        return $resultPersoon;
    }

    public function getPersoonById(int $id): ?Persoon {
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $sql = "SELECT * FROM personen WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':id' => $id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
      
        if (!$row) { 
            return null; 
        }
        return new Persoon((int)$row['id'],$row['familienaam'], $row['voornaam'], $row['geslacht'] );
    }
        
      
    
    
} 
   
