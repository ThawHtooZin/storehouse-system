<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['item_type_id', 'sku', 'name', 'current_quantity', 'min_stock_level'])]
class Item extends Model
{
    use HasFactory;

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'current_quantity' => 'integer',
            'min_stock_level' => 'integer',
        ];
    }
}
