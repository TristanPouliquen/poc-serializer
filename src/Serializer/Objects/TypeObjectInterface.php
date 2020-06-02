<?php
declare(strict_types=1);

namespace App\Serializer\Objects;

interface TypeObjectInterface extends \Stringable
{
    public function normalize();
}
