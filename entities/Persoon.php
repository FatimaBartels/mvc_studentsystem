<?php

declare(strict_types = 1);

class Persoon
{
    private ?int $id;
    private string $familienaam;
    private string $voornaam;
    private string $geslacht;
  

    public function __construct(string $familienaam, string $voornaam, string $geslacht, ?int $id = null)
    {
        $this->id    = $id;
        $this->familienaam = $familienaam;
        $this->voornaam  = $voornaam;
        $this->geslacht  = $geslacht;
       
    }

   public static function create(
    
    string $familienaam, string $voornaam, string $geslacht, ?int $id = null
        ): Persoon
    {
        return new Persoon($familienaam, $voornaam, $geslacht, $id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilienaam(): string
    {
        return $this->familienaam;
    }

    public function getVoornaam(): string
    {
        return $this->voornaam;
    }

    public function getGeslacht(): string
    {
        return $this->geslacht;
    }


}
