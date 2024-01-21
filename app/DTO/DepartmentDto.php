<?php

namespace App\DTO;

class DepartmentDto extends AbstractDto
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title
        ];
    }
}