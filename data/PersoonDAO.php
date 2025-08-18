<?php

require_once("data/DBConfig.php"); 
require_once( "entities/Persoon.php");

class PersoonDAO
{
   
    public function getPersonenList(): array
    {
     
        $sql = "SELECT id, familienaam, voornaam, geslacht FROM personen";
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $data = $dbh->query($sql);
       

        $resultPersoon = [];
        foreach ($data as $persoon) {
            $resultPersoon [] = Persoon::create(
                $persoon['familienaam'],
                $persoon['voornaam'],
                $persoon['geslacht'],
                (int)$persoon['id']
            );
        }

        $dbh = null;

        return $resultPersoon;
    }

    public function getPersoonById(int $id): ? Persoon {
        
        $sql = "SELECT * FROM personen WHERE id = :id";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);

        $stmt->execute([':id' => $id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return Persoon::create(
                $row['familienaam'],
                $row['voornaam'],
                $row['geslacht'],
                (int)$row['id']
            );
        }
    
        $dbh = null;
        return null;
    }
    
   
}