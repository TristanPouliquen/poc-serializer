<?php

namespace App\Serializer\Normalizer;

use App\Entity\BankAccount;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BankAccountNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    private const SUPPORTED_FORMATS = ['json'];
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['iban'] = trim(chunk_split($data['iban'], 4, ' '));

        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof BankAccount;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return BankAccount::class === $type && in_array($format, self::SUPPORTED_FORMATS);
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $bankAccount = new BankAccount();

        $bankAccount->setIban(preg_replace('/\s+/', '', $data["iban"]));
        $bankAccount->setBic($data["bic"]);
        $bankAccount->setName($data["name"]);

        return $bankAccount;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
