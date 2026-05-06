<?php

namespace App\Entity;

class Chain
{
    private array $blocks;

    public function __construct(array $blocks)
    {
        $this->blocks = $blocks;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function update(array $blocks): self
    {
        $this->blocks = $blocks;
        return $this;
    }
}
