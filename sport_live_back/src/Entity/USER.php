<?php

namespace App\Entity;

use App\Repository\USERRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=USERRepository::class)
 */
class USER
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
    private $FIRSTNAME;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LASTNAME;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ALIAS;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EMAIL;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PASSWORD;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ROLE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFIRSTNAME(): ?string
    {
        return $this->FIRSTNAME;
    }

    public function setFIRSTNAME(string $FIRSTNAME): self
    {
        $this->FIRSTNAME = $FIRSTNAME;

        return $this;
    }

    public function getLASTNAME(): ?string
    {
        return $this->LASTNAME;
    }

    public function setLASTNAME(string $LASTNAME): self
    {
        $this->LASTNAME = $LASTNAME;

        return $this;
    }

    public function getALIAS(): ?string
    {
        return $this->ALIAS;
    }

    public function setALIAS(string $ALIAS): self
    {
        $this->ALIAS = $ALIAS;

        return $this;
    }

    public function getEMAIL(): ?string
    {
        return $this->EMAIL;
    }

    public function setEMAIL(string $EMAIL): self
    {
        $this->EMAIL = $EMAIL;

        return $this;
    }

    public function getPASSWORD(): ?string
    {
        return $this->PASSWORD;
    }

    public function setPASSWORD(string $PASSWORD): self
    {
        $this->PASSWORD = $PASSWORD;

        return $this;
    }

    public function getROLE(): ?string
    {
        return $this->ROLE;
    }

    public function setROLE(string $ROLE): self
    {
        $this->ROLE = $ROLE;

        return $this;
    }
}
