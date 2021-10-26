<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $division;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity=Season::class, inversedBy="teams")
     */
    private $season;

    /**
     * @ORM\OneToMany(targetEntity=PlayerDetails::class, mappedBy="team")
     */
    private $playerDetails;

    /**
     * @ORM\ManyToMany(targetEntity=Player::class, mappedBy="teams")
     */
    private $players;

    public function __construct()
    {
        $this->playerDetails = new ArrayCollection();
        $this->player = new ArrayCollection();
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDivision(): ?string
    {
        return $this->division;
    }

    public function setDivision(string $division): self
    {
        $this->division = $division;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @return Collection|PlayerDetails[]
     */
    public function getPlayerDetails(): Collection
    {
        return $this->playerDetails;
    }

    public function addPlayerDetail(PlayerDetails $playerDetail): self
    {
        if (!$this->playerDetails->contains($playerDetail)) {
            $this->playerDetails[] = $playerDetail;
            $playerDetail->setTeam($this);
        }

        return $this;
    }

    public function removePlayerDetail(PlayerDetails $playerDetail): self
    {
        if ($this->playerDetails->removeElement($playerDetail)) {
            // set the owning side to null (unless already changed)
            if ($playerDetail->getTeam() === $this) {
                $playerDetail->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->addTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            $player->removeTeam($this);
        }

        return $this;
    }
}
