<?php

namespace App\Entity;

use App\Repository\AssignmentHeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignmentHeaderRepository::class)]
class AssignmentHeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $AssignmentName;

    #[ORM\Column(type: 'string', length: 255)]
    private $ModuleId;

    #[ORM\Column(type: 'string', length: 255)]
    private $Content;

    #[ORM\Column(type: 'string', length: 255)]
    private $attachment;

    #[ORM\Column(type: 'datetime')]
    private $SubmitBefore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignmentName(): ?string
    {
        return $this->AssignmentName;
    }

    public function setAssignmentName(string $AssignmentName): self
    {
        $this->AssignmentName = $AssignmentName;

        return $this;
    }

    public function getModuleId(): ?string
    {
        return $this->ModuleId;
    }

    public function setModuleId(string $ModuleId): self
    {
        $this->ModuleId = $ModuleId;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getSubmitBefore(): ?\DateTimeInterface
    {
        return $this->SubmitBefore;
    }

    public function setSubmitBefore(\DateTimeInterface $SubmitBefore): self
    {
        $this->SubmitBefore = $SubmitBefore;

        return $this;
    }
}
