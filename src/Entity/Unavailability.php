<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnavailabilityRepository")
 */
class Unavailability
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startingOn;

    /**
     * @ORM\Column(type="date")
     */
    private $endingOn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="unavailabilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingOn(): ?DateTimeInterface
    {
        return $this->startingOn;
    }

    public function setStartingOn(DateTimeInterface $startingOn): self
    {
        $this->startingOn = $startingOn;

        return $this;
    }

    public function getEndingOn(): ?DateTimeInterface
    {
        return $this->endingOn;
    }

    public function setEndingOn(DateTimeInterface $endingOn): self
    {
        $this->endingOn = $endingOn;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }
}
