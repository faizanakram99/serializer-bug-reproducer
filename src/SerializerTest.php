<?php

namespace App;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerTest extends TestCase
{
    private DenormalizerInterface $denormalizer;

    protected function setUp(): void
    {
        $this->denormalizer = new Serializer([
            new ObjectNormalizer(nameConverter: new CamelCaseToSnakeCaseNameConverter()),
        ]);
    }

    public function test_it_denormalizes_snake_case_into_camel_case_without_ctor(): void
    {
        $person = $this->denormalizer->denormalize(['first_name' => 'Super'], PersonWithoutCtor::class);

        $expected = new PersonWithoutCtor();
        $expected->firstName = 'Super';

        self::assertEquals(
            $expected,
            $person,
            'snake_case is denormalized into camelCase',
        );
    }

    public function test_it_denormalizes_camel_case_into_camel_case_without_ctor(): void
    {
        $person = $this->denormalizer->denormalize(['firstName' => 'Super'], PersonWithoutCtor::class);

        $expected = new PersonWithoutCtor();
        $expected->firstName = 'Super';

        self::assertEquals(
            $expected,
            $person,
            'camelCase is denormalized into camelCase without any errors',
        );
    }

    public function test_it_denormalizes_snake_case_into_camel_case_with_ctor(): void
    {
        $person = $this->denormalizer->denormalize(['first_name' => 'Super'], PersonWithCtor::class);

        self::assertEquals(
            new PersonWithCtor('Super'),
            $person,
            'snake_case is denormalized into camelCase using ctor',
        );
    }

    /**
     * This test fails
     */
    public function test_it_denormalizes_camel_case_into_camel_case_with_ctor(): void
    {
        $person = $this->denormalizer->denormalize(['firstName' => 'Super'], PersonWithCtor::class);

        self::assertEquals(
            new PersonWithCtor('Super'),
            $person,
            'camelCase is denormalized into camelCase using ctor',
        );
    }
}