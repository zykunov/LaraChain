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

    /**
     * Мутатор для преобразования Unix‑timestamp в DATETIME
     */
    public function setTimestampAttribute($value): void
    {
        if (is_int($value)) {
            $this->attributes['timestamp'] = date('Y-m-d H:i:s', $value);
        } else {
            $this->attributes['timestamp'] = $value;
        }
    }

    /**
     * Аксессор для обратного преобразования (опционально)
     */
    public function getTimestampAttribute($value)
    {
        return strtotime($value); // возвращает Unix‑timestamp
    }


}
