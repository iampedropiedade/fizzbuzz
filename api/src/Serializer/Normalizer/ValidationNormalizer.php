<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Dto\ValidationDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

readonly class ValidationNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @param ValidationFailedException $data
     * @param array<string, mixed>      $context
     *
     * @return array<string, mixed>
     *
     * @throws ExceptionInterface
     */
    public function normalize($data, ?string $format = null, array $context = []): array
    {
        $validation = new ValidationDto();
        foreach ($data->getViolations() as $violation) {
            $validation->addViolation($violation);
        }
        $normalizedData = $this->normalizer->normalize($validation, $format, $context);
        if (!is_array($normalizedData)) {
            throw new UnexpectedValueException();
        }

        return $normalizedData;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ValidationFailedException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ValidationFailedException::class => true,
        ];
    }
}
