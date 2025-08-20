<?php

// Class Punt.php

declare(strict_types = 1);

require_once("entities/Persoon.php") ;
require_once("entities/Module.php") ;



class Punt
{
    private Module $module;
    private Persoon $persoon;
    private ?int $punt;

    public function __construct(Persoon $persoon, Module $module, int $punt)
    {
        $this->persoon = $persoon;
        $this->module  = $module;
        $this->punt    = $punt;
    }

    public static function create(Persoon $persoon, Module $module, ?int $punt): Punt
    {
        return new Punt($persoon, $module, $punt);
    }

    public function getModule(): Module
    {
        return $this->module;
    }

    public function getPersoon(): Persoon
    {
        return $this->persoon;
    }

    public function getPunt(): ?int
    {
        return $this->punt;
    }
}
