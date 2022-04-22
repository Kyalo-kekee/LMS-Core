<?php

namespace App\Entity;

use App\Repository\CourseHeaderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: CourseHeaderDetailsRepository::class)]
class CourseHeaderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?int $CourseId;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ModuleName;

    #[ORM\Column(type: 'text')]
    private ?string $ModuleDescription;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ModuleContent;

    #[ORM\Column(type: 'string', length: 255)]
    private $ModuleDuration;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ModuleAttachment= '';

    #[Vich\UploadableField(mapping: "courses",fileNameProperty: 'ModuleAttachment', size: 'AttachmentSize')]
    private  $AttachmentFile;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $AttachmentSize;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public  function setAttachmentFile(?File $file = null):void
    {
        $this ->AttachmentFile = $file;
        if(null !== $file){
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this ->UpdatedAt = new \DateTimeImmutable();
        }
    }
    public  function getAttachmentFile()
    {
        return $this->AttachmentFile;
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

    public function getModuleDescription(): ?string
    {
        return $this->ModuleDescription;
    }

    public function setModuleDescription(string $ModuleDescription): self
    {
        $this->ModuleDescription = $ModuleDescription;

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

    public function getModuleDuration(): ?string
    {
        return $this->ModuleDuration;
    }

    public function setModuleDuration(string $ModuleDuration): self
    {
        $this->ModuleDuration = $ModuleDuration;

        return $this;
    }

    public function getModuleAttachment(): ?string
    {
        return $this->ModuleAttachment;
    }

    public function setModuleAttachment(string $ModuleAttachment): self
    {
        $this->ModuleAttachment = $ModuleAttachment;

        return $this;
    }

    public function getAttachmentSize(): ?int
    {
        return $this->AttachmentSize;
    }

    public function setAttachmentSize(?int $AttachmentSize): self
    {
        $this->AttachmentSize = $AttachmentSize;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }
}
