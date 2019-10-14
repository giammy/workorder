<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\WorkslistRepository")
 */
class Workslist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activityCodePrefix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activityCodeSuffix;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $workorder;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $responsible;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deputy;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $validFrom;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $validTo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastChangeAuthor;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $lastChangeDate;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $internalNote;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAnOldCopy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityCodePrefix(): ?string
    {
        return $this->activityCodePrefix;
    }

    public function setActivityCodePrefix(string $activityCodePrefix): self
    {
        $this->activityCodePrefix = $activityCodePrefix;

        return $this;
    }

    public function getActivityCodeSuffix(): ?string
    {
        return $this->activityCodeSuffix;
    }

    public function setActivityCodeSuffix(string $activityCodeSuffix): self
    {
        $this->activityCodeSuffix = $activityCodeSuffix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWorkorder(): ?string
    {
        return $this->workorder;
    }

    public function setWorkorder(string $workorder): self
    {
        $this->workorder = $workorder;

        return $this;
    }

    public function getResponsible(): ?string
    {
        return $this->responsible;
    }

    public function setResponsible(string $responsible): self
    {
        $this->responsible = $responsible;

        return $this;
    }

    public function getDeputy(): ?string
    {
        return $this->deputy;
    }

    public function setDeputy(?string $deputy): self
    {
        $this->deputy = $deputy;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(\DateTimeInterface $validFrom): self
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidTo(): ?\DateTimeInterface
    {
        return $this->validTo;
    }

    public function setValidTo(\DateTimeInterface $validTo): self
    {
        $this->validTo = $validTo;

        return $this;
    }

    public function getLastChangeAuthor(): ?string
    {
        return $this->lastChangeAuthor;
    }

    public function setLastChangeAuthor(string $lastChangeAuthor): self
    {
        $this->lastChangeAuthor = $lastChangeAuthor;

        return $this;
    }

    public function getLastChangeDate(): ?\DateTimeInterface
    {
        return $this->lastChangeDate;
    }

    public function setLastChangeDate(\DateTimeInterface $lastChangeDate): self
    {
        $this->lastChangeDate = $lastChangeDate;

        return $this;
    }

    public function getInternalNote(): ?string
    {
        return $this->internalNote;
    }

    public function setInternalNote(?string $internalNote): self
    {
        $this->internalNote = $internalNote;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getIsAnOldCopy(): ?bool
    {
        return $this->isAnOldCopy;
    }

    public function setIsAnOldCopy(bool $isAnOldCopy): self
    {
        $this->isAnOldCopy = $isAnOldCopy;

        return $this;
    }
}
