<?php

namespace Entity;

use Repository\ConfigRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigRepository::class)]
#[ORM\Table(name: 'config')]
class Config
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $settingName;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private string $settingValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Config
    {
        $this->id = $id;
        return $this;
    }

    public function getSettingName(): ?string
    {
        return $this->settingName;
    }

    public function setSettingName(string $settingName): Config
    {
        $this->settingName = $settingName;
        return $this;
    }

    public function getSettingValue(): ?string
    {
        return $this->settingValue;
    }

    public function setSettingValue(string $settingValue): Config
    {
        $this->settingValue = $settingValue;
        return $this;
    }
}
