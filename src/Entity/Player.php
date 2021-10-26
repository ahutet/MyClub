<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=PlayerDetails::class, mappedBy="player")
     */
    private $playerDetails;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="players")
     */
    private $teams;

    public function __construct()
    {
        $this->playerDetails = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullName(bool $reverse = false)
    {
        if ($reverse) {
            return trim(mb_convert_case(sprintf("%s %s",
                $this->getLastname() ?: "",
                $this->getFirstname() ?: ""
            ), MB_CASE_TITLE, "UTF-8"));
        }
        return trim(mb_convert_case(sprintf("%s %s",
            $this->getFirstname() ?: "",
            $this->getLastname() ?: ""
        ), MB_CASE_TITLE, "UTF-8"));
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $playerDetail->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerDetail(PlayerDetails $playerDetail): self
    {
        if ($this->playerDetails->removeElement($playerDetail)) {
            // set the owning side to null (unless already changed)
            if ($playerDetail->getPlayer() === $this) {
                $playerDetail->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        $this->teams->removeElement($team);

        return $this;
    }

}
