<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'full_name',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddress(): string
    {
        $parts = [$this->address_line_1];
        if ($this->address_line_2) {
            $parts[] = $this->address_line_2;
        }
        $parts[] = $this->city . ', ' . $this->state . ' ' . $this->postal_code;
        $parts[] = $this->country;
        return implode(', ', $parts);
    }
}
