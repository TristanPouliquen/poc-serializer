<?php
declare(strict_types=1);

namespace App\Serializer\Objects;

class Bic implements TypeObjectInterface
{
    private $bic;

    public function __construct(string $bic)
    {
        $this->bic = $bic;
    }

    public function getBic(): string
    {
        return $this->bic;
    }

    public function setBic(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function __toString()
    {
        return strtoupper($this->bic);
    }

    public function normalize(): string
    {
        return $this->__toString();
    }
}
