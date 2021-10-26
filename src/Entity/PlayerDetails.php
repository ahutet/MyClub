<?php

namespace App\Entity;

use App\Repository\PlayerDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerDetailsRepository::class)
 */
class PlayerDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbMatch;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbMinutes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPass;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbGoals;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="playerDetails")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="playerDetails")
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbMatch(): ?int
    {
        return $this->nbMatch;
    }

    public function setNbMatch(?int $nbMatch): self
    {
        $this->nbMatch = $nbMatch;

        return $this;
    }

    public function getNbMinutes(): ?int
    {
        return $this->nbMinutes;
    }

    public function setNbMinutes(?int $nbMinutes): self
    {
        $this->nbMinutes = $nbMinutes;

        return $this;
    }

    public function getNbPass(): ?int
    {
        return $this->nbPass;
    }

    public function setNbPass(?int $nbPass): self
    {
        $this->nbPass = $nbPass;

        return $this;
    }

    public function getNbGoals(): ?int
    {
        return $this->nbGoals;
    }

    public function setNbGoals(?int $nbGoals): self
    {
        $this->nbGoals = $nbGoals;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

}
