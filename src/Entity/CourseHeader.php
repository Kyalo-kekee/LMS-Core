<?php

namespace App\Entity;

use App\Repository\CourseHeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseHeaderRepository::class)]
class CourseHeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $CourseName;

    #[ORM\Column(type: 'datetime')]
    private $CourseDuration;

    #[ORM\Column(type: 'string', length: 255)]
    private $CourserTutor;

    #[ORM\Column(type: 'string', length: 255)]
    private $ClassId;

    #[ORM\Column(type: 'boolean')]
    private $IsActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseName(): ?string
    {
        return $this->CourseName;
    }

    public function setCourseName(string $CourseName): self
    {
        $this->CourseName = $CourseName;

        return $this;
    }

    public function getCourseDuration(): ?\DateTimeInterface
    {
        return $this->CourseDuration;
    }

    public function setCourseDuration(\DateTimeInterface $CourseDuration): self
    {
        $this->CourseDuration = $CourseDuration;

        return $this;
    }

    public function getCourserTutor(): ?string
    {
        return $this->CourserTutor;
    }

    public function setCourserTutor(string $CourserTutor): self
    {
        $this->CourserTutor = $CourserTutor;

        return $this;
    }

    public function getClassId(): ?string
    {
        return $this->ClassId;
    }

    public function setClassId(string $ClassId): self
    {
        $this->ClassId = $ClassId;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->IsActive;
    }

    public function setIsActive(bool $IsActive): self
    {
        $this->IsActive = $IsActive;

        return $this;
    }
}
