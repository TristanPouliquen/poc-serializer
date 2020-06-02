<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Serializer\Objects\TypeObjectInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TypeObjectNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = []): string
    {
        return $object->normalize();
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof TypeObjectInterface;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
