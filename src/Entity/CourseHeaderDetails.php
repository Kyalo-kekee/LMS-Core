<?php

namespace App\Entity;

use App\Repository\CourseHeaderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseHeaderDetailsRepository::class)]
class CourseHeaderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $CourseId;

    #[ORM\Column(type: 'string', length: 255)]
    private $ModuleName;

    #[ORM\Column(type: 'text')]
    private $ModuleDecription;

    #[ORM\Column(type: 'string', length: 255)]
    private $ModuleContent;

    #[ORM\Column(type: 'datetime')]
    private $ModuleDuration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseId(): ?int
    {
        return $this->CourseId;
    }

    public function setCourseId(int $CourseId): self
    {
        $this->CourseId = $CourseId;

        return $this;
    }

    public function getModuleName(): ?string
    {
        return $this->ModuleName;
    }

    public function setModuleName(string $ModuleName): self
    {
        $this->ModuleName = $ModuleName;

        return $this;
    }

    public function getModuleDecription(): ?string
    {
        return $this->ModuleDecription;
    }

    public function setModuleDecription(string $ModuleDecription): self
    {
        $this->ModuleDecription = $ModuleDecription;

        return $this;
    }

    public function getModuleContent(): ?string
    {
        return $this->ModuleContent;
    }

    public function setModuleContent(string $ModuleContent): self
    {
        $this->ModuleContent = $ModuleContent;

        return $this;
    }

    public function getModuleDuration(): ?\DateTimeInterface
    {
        return $this->ModuleDuration;
    }

    public function setModuleDuration(\DateTimeInterface $ModuleDuration): self
    {
        $this->ModuleDuration = $ModuleDuration;

        return $this;
    }
}
