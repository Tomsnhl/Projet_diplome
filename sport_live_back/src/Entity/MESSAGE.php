<?php

namespace App\Entity;

use App\Repository\MESSAGERepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MESSAGERepository::class)
 */
class MESSAGE
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
    private $CONTENT;

    /**
     * @ORM\Column(type="datetime")
     */
    private $SENT_DATE;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IS_APPROUVED;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IS_DELETED;

    /**
     * @ORM\Column(type="integer")
     */
    private $USER_ID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCONTENT(): ?string
    {
        return $this->CONTENT;
    }

    public function setCONTENT(string $CONTENT): self
    {
        $this->CONTENT = $CONTENT;

        return $this;
    }

    public function getSENTDATE(): ?\DateTimeInterface
    {
        return $this->SENT_DATE;
    }

    public function setSENTDATE(\DateTimeInterface $SENT_DATE): self
    {
        $this->SENT_DATE = $SENT_DATE;

        return $this;
    }

    public function isISAPPROUVED(): ?bool
    {
        return $this->IS_APPROUVED;
    }

    public function setISAPPROUVED(?bool $IS_APPROUVED): self
    {
        $this->IS_APPROUVED = $IS_APPROUVED;

        return $this;
    }

    public function isISDELETED(): ?bool
    {
        return $this->IS_DELETED;
    }

    public function setISDELETED(?bool $IS_DELETED): self
    {
        $this->IS_DELETED = $IS_DELETED;

        return $this;
    }

    public function getUSERID(): ?int
    {
        return $this->USER_ID;
    }

    public function setUSERID(int $USER_ID): self
    {
        $this->USER_ID = $USER_ID;

        return $this;
    }
}
