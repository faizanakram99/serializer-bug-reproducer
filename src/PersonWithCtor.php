<?php

namespace App;

class PersonWithCtor
{
    public readonly string $name;

    public function __construct(
        string $firstName,
    ) {
        $this->name = $firstName;
    }
}
