<?php

namespace App\DTO;

abstract class AbstractDto
{
    abstract public function toArray(): array;
}