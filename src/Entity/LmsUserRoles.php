<?php

namespace App\Entity;

use App\Repository\LmsUserRolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LmsUserRolesRepository::class)]
class LmsUserRoles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nameRole;

    #[ORM\Column(type: 'boolean')]
    private ?bool $IsEnabled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRole(): ?string
    {
        return $this->nameRole;
    }

    public function setNameRole(string $nameRole): self
    {
        $this->nameRole = $nameRole;

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->IsEnabled;
    }

    public function setIsEnabled(bool $IsEnabled): self
    {
        $this->IsEnabled = $IsEnabled;

        return $this;
    }
}
