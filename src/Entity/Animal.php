<?php

namespace App\Entity;

class Animal
{
    private int $id;
    private string $prenom;
    private string $race;
    private string $etat;
    private string $image;
    private int $habitatId;

    public function __construct(int $id, string $prenom, string $race, string $etat, string $image, int $habitatId)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->race = $race;
        $this->etat = $etat;
        $this->image = $image;
        $this->habitatId = $habitatId;
    }

    // Getters uniquement (ajouter des setters si nécessaire)
    public function getId(): int { return $this->id; }
    public function getPrenom(): string { return $this->prenom; }
    public function getRace(): string { return $this->race; }
    public function getEtat(): string { return $this->etat; }
    public function getImage(): string { return $this->image; }
    public function getHabitatId(): int { return $this->habitatId; }
}
