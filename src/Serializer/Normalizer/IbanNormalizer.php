<?php

namespace App\Serializer\Normalizer;

use App\Serializer\Iban;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class IbanNormalizer extends TypeObjectNormalizer implements DenormalizerInterface
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * Overriden parent method for specific normalization
     */
    public function normalize($object, string $format = null, array $context = array()): string
    {
        return str_shuffle($object->normalize());
    }

    /**
     * Overridden parent method for specific normalization.
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Iban;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new Iban(strtoupper(preg_replace('/\s+/', '', $data)));
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return Iban::class === $type;
    }
}
