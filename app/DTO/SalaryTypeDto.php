<?php

namespace App\DTO;

class SalaryTypeDto extends AbstractDto
{
    private int    $type;
    private string $title;

    public function __construct(int $type, string $title)
    {
        $this->type  = $type;
        $this->title = $title;
    }

    public function toArray(): array
    {
        return [
            'type'  => $this->type,
            'title' => $this->title
        ];
    }
}