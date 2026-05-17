<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'chain_id',
        'data',
        'timestamp',
        'previous_hash',
        'hash',
    ];

    public function chain(): BelongsTo
    {
        return $this->belongsTo(Chain::class);
    }


    public function setHashAttribute(string $hash): void
    {
        $this->attributes['hash'] = $hash;
    }

    public function getIndexAttribute(): int
    {
        return $this->id;
    }

    public function getHashAttribute(): string
    {
        return $this->attributes['hash'];
    }

    public function getPreviousHashAttribute(): string
    {
        return $this->attributes['previous_hash'];
    }


    public function getDataAttribute(): string
    {
        return $this->attributes['data'];
    }

    public function getTimestampAttribute(): int
    {
        return strtotime($this->attributes['timestamp']);
    }

    public function setTimestampAttribute($value): void
    {
        if (is_int($value)) {
            $this->attributes['timestamp'] = date('Y-m-d H:i:s', $value);
        } else {
            $this->attributes['timestamp'] = $value;
        }
    }
}
