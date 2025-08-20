<?php 
//business/PuntService.php 


declare(strict_types=1);


require_once('data/PuntDAO.php');
require_once('entities/Punt.php');
require_once('entities/Persoon.php');
require_once('entities/Module.php');

class PuntService
{
    private PuntDAO $puntDAO;


    public function __construct()
    {
        $this->puntDAO = new PuntDAO();
    }

/**
* Build Punt entities with caching of Persoon/Module objects created from joined rows.
*/
    public function getPuntenPerModule(int $moduleId): array
    {
        $rows = $this->puntDAO->getPuntenVoorModule($moduleId);

        $persoonCache = [];
        $moduleCache = [];
        $result = [];


        foreach ($rows as $r) {
        $pid = (int)$r['persoonId'];
        $mid = (int)$r['moduleId'];


        if (!isset($persoonCache[$pid])) {
        $persoonCache[$pid] = new Persoon($pid, $r['familienaam'], $r['voornaam'], $r['geslacht'] );
        }
        if (!isset($moduleCache[$mid])) {
        $moduleCache[$mid] = new Module($mid, $r['moduleNaam']);
        }


        $result[] = new Punt($persoonCache[$pid], $moduleCache[$mid], (int)$r['punt']);
        }


        return $result;
        }

    public function getPuntOverzicht(): array
    {
        $rows = $this->puntDAO->getPuntenList();


        $persoonCache = [];
        $moduleCache = [];
        $result = [];


        foreach ($rows as $r) {
        $pid = (int)$r['persoonId'];
        $mid = (int)$r['moduleId'];


        if (!isset($persoonCache[$pid])) {
        $persoonCache[$pid] = new Persoon($pid, $r['familienaam'], $r['voornaam'], $r['geslacht'] );
        }
        if (!isset($moduleCache[$mid])) {
        $moduleCache[$mid] = new Module($mid, $r['moduleNaam']);
        }


        $result[] = new Punt($persoonCache[$pid], $moduleCache[$mid], (int)$r['punt']);
        }


    return $result;
    }

    public function getPuntenPerPersoon(int $persoonId): array {
        $puntDAO = new PuntDAO();
        return $puntDAO->getPuntenByPersoon($persoonId);
    
    }

    public function voegPuntToe(int $persoonId, int $moduleId, int $punt): void { 
        if ($punt < 0 || $punt > 100) {
            throw new OngeldigPuntException("Punt moet tussen 0 en 100 liggen.");
        }
        $puntDAO = new PuntDAO();

         if ($puntDAO->puntToegevoegd($persoonId, $moduleId)) {
            throw new PuntBestaatAlException("Student heeft al een punt voor dit module.");
        }
        $puntDAO->create($persoonId, $moduleId, $punt); 
    } 

/*
    public function haalPuntenPersoonId(int $persoonId): array
        {
        $rows = $this->puntDAO->getByPersoonId($persoonId);


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
    }*/

   



    }

    /*
    public function getPuntOverzicht(): array { 
        $puntDAO = new PuntDAO(); 
        $puntenLijst = $puntDAO->getPuntenList(); 
        return $puntenLijst; 
    } 

    public function getPuntenPerModule(int $moduleId): array { 
        $puntDAO = new PuntDAO(); 
        $puntLijst = $puntDAO->getPuntenVoorModule($moduleId); 
        return $puntLijst;
        
    }

    public function haalPuntenPersoonId(int $persoonId): array { 
        $puntDAO = new PuntDAO(); 
        $punt = $puntDAO->getPuntenByPersoonId($persoonId); 
        return $punt;
        
    }*/
