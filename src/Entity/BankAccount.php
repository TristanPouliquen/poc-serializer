<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Serializer\Objects\Bic;
use App\Serializer\Objects\Iban;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var Iban
     * @Assert\Iban()
     * @ORM\Column(type="iban")
     */
    private $iban;

    /**
     * @Assert\Bic(ibanPropertyPath="iban")
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

    public function getIban(): Iban
    {
        return $this->iban;
    }

    public function setIban(Iban $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): Bic
    {
        return $this->bic;
    }

    public function setBic(Bic $bic): self
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
