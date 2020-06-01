<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="iban")
     */
    private $iban;

    /**
     * @ORM\Column(type="bic")
     */
    private $bic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban()
    {
        return $this->iban;
    }

    public function setIban($iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic()
    {
        return $this->bic;
    }

    public function setBic($bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
