<?php

namespace App\Serializer\Normalizer;

use App\Serializer\Bic;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BicNormalizer extends TypeObjectNormalizer implements DenormalizerInterface
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new Bic(strtoupper(preg_replace('/\s+/', '', $data)));
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return Bic::class === $type;
    }
}
