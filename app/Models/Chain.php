<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{
    protected $fillable = [
        'chain',
    ];

    protected $casts = [
        'chain' => 'array',
    ];


    public function getBlocksAttribute(): array
    {
        return $this->attributes['chain'] ?? [];
    }


    public function setBlocksAttribute(array $blocks): void
    {
        $this->attributes['chain'] = $blocks;
    }


    public function updateBlocks(array $blocks): self
    {
        $this->chain = $blocks;
        return $this;
    }
}
