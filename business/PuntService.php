<?php 
// business/PuntService.php 

declare(strict_types=1);

require_once('data/PuntDAO.php');
require_once('entities/Punt.php');
require_once('entities/Persoon.php');
require_once('entities/Module.php');
require_once('exceptions/PuntBestaatAlException.php');
require_once('exceptions/OngeldigPuntException.php');

class PuntService
{
    private PuntDAO $puntDAO;

    public function __construct()
    {
        $this->puntDAO = new PuntDAO();
    }


    public function getPuntenPerModule(int $moduleId): array {
        $rows = $this->puntDAO->getPuntenVoorModule($moduleId);
        return $this->mapRowsToPunten($rows);
    }


    public function getPuntOverzicht(): array {
        $rows = $this->puntDAO->getPuntenList();
        return $this->mapRowsToPunten($rows);
    }

    public function getPuntenPerPersoon(int $persoonId): array {
        return $this->puntDAO->getPuntenByPersoon($persoonId);
    }

   
    public function voegPuntToe(int $persoonId, int $moduleId, int $punt): void { 
        if ($punt < 0 || $punt > 100) {
            throw new OngeldigPuntException("Punt moet tussen 0 en 100 liggen.");
        }

        if ($this->puntDAO->puntBestaat($persoonId, $moduleId)) {
            throw new PuntBestaatAlException("Student heeft al een punt voor dit module.");
        }

        $this->puntDAO->create($persoonId, $moduleId, $punt); 
    } 


    // om geen duplicatie van code te hebben, private helper
    private function mapRowsToPunten(array $rows): array {
        $persoonCache = [];
        $moduleCache = [];
        $result = [];

        foreach ($rows as $r) {
            $pid = (int)$r['persoonId'];
            $mid = (int)$r['moduleId'];

            if (!isset($persoonCache[$pid])) {
                $persoonCache[$pid] = new Persoon($pid, $r['familienaam'], $r['voornaam'], $r['geslacht']);
            }
            if (!isset($moduleCache[$mid])) {
                $moduleCache[$mid] = new Module($mid, $r['moduleNaam']);
            }

            $result[] = new Punt($persoonCache[$pid], $moduleCache[$mid], (int)$r['punt']);
        }

        return $result;
    }
}
