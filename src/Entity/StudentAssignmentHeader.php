<?php

namespace App\Entity;

use App\Repository\StudentAssignmentHeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentAssignmentHeaderRepository::class)]
class StudentAssignmentHeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ModuleId;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $StudentScore;

    #[ORM\Column(type: 'text', nullable: true)]
    private $Content;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Attachment;

    #[ORM\Column(type: 'datetime')]
    private $SubmitDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $StudentId;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStudentScore(): ?int
    {
        return $this->StudentScore;
    }

    public function setStudentScore(?int $StudentScore): self
    {
        $this->StudentScore = $StudentScore;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getAttachment(): ?string
    {
        return $this->Attachment;
    }

    public function setAttachment(?string $Attachment): self
    {
        $this->Attachment = $Attachment;

        return $this;
    }

    public function getSubmitDate(): ?\DateTimeInterface
    {
        return $this->SubmitDate;
    }

    public function setSubmitDate(\DateTimeInterface $SubmitDate): self
    {
        $this->SubmitDate = $SubmitDate;

        return $this;
    }

    public function getStudentId(): ?string
    {
        return $this->StudentId;
    }

    public function setStudentId(string $StudentId): self
    {
        $this->StudentId = $StudentId;

        return $this;
    }
}
