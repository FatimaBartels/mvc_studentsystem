<?php
// data/PuntDAO.php

require_once("data/DBConfig.php");
require_once("entities/Punt.php");
require_once("entities/Persoon.php");
require_once("entities/Module.php");
require_once("data/PersoonDAO.php");
require_once("data/ModuleDAO.php");


class PuntDAO
{

    private function getConnection(): PDO {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

    public function getPuntenList(): array {

        $sql = "SELECT p.punt,
                       pers.id AS persoonId, pers.familienaam, pers.voornaam, pers.geslacht,
                       m.id AS moduleId, m.naam AS moduleNaam
                FROM punten p
                JOIN personen pers ON p.persoonId = pers.id
                JOIN modules m ON p.moduleId = m.id";

        $dbh = $this->getConnection();

        $data = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return $data;
    }


    public function getPuntenVoorModule(int $moduleId): array {

        $sql = "SELECT p.punt,
                       pers.id AS persoonId, pers.familienaam, pers.voornaam, pers.geslacht,
                       m.id AS moduleId, m.naam AS moduleNaam
                FROM punten p
                JOIN personen pers ON p.persoonId = pers.id
                JOIN modules m ON p.moduleId = m.id
                WHERE m.id = :moduleId
                ORDER BY pers.familienaam, pers.voornaam";

        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":moduleId" => $moduleId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $dbh = null;
        return $data;
    }


    public function getPuntenByPersoon(int $persoonId): array {

        $sql = "SELECT * FROM punten WHERE persoonId = :persoonId";

        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":persoonId" => $persoonId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;

        // Map to Punt entities
        $persoonDAO = new PersoonDAO();
        $moduleDAO  = new ModuleDAO();
        $result = [];
        foreach ($rows as $row) {
            $persoon = $persoonDAO->getPersoonById((int)$row["persoonId"]);
            $module  = $moduleDAO->getModuleById((int)$row["moduleId"]);
            $result[] = new Punt($persoon, $module, (int)$row["punt"]);
        }

        return $result;
    }


    public function puntBestaat(int $persoonId, int $moduleId): bool {

        $sql = "SELECT COUNT(*) FROM punten WHERE persoonId = :persoonId AND moduleId = :moduleId";

        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":persoonId" => $persoonId, ":moduleId" => $moduleId]);
        $count = (int)$stmt->fetchColumn();

        $dbh = null;
        return $count > 0;
    }

    public function create(int $persoonId, int $moduleId, int $punt): void {

        $sql = "INSERT INTO punten (moduleId, persoonId, punt) VALUES (:moduleId, :persoonId, :punt)";

        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ":moduleId"  => $moduleId,
            ":persoonId" => $persoonId,
            ":punt"      => $punt
        ]);

        $dbh = null;
    }
}
