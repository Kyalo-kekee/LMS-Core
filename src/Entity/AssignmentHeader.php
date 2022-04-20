<?php

namespace App\Entity;

use App\Repository\AssignmentHeaderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AssignmentHeaderRepository::class)]
#[Vich\Uploadable]
class AssignmentHeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $AssignmentName;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ModuleId;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $Content;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $Attachment;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $SubmitBefore;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $AttachmentSize;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt;

    #[Vich\UploadableField(mapping: 'assignment_files',fileNameProperty: 'Attachment', size: 'AttachmentSize')]
    private ?File $AttachmentFile = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public  function setAttachmentFile(?File $file = null):void
    {
        $this ->Attachment = $file;
        if(null !== $file){
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this ->UpdatedAt = new \DateTimeImmutable();
        }
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
        return $this->Attachment;
    }

    public function setAttachment(string $Attachment): self
    {
        $this->Attachment = $Attachment;

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
