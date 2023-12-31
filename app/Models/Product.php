<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendor(): BelongsTo
    {
        //THIS RELATION WAS DEFINED IN MIGRATION ALREADY
        //return $this->belongsTo(User::class); //THIS WORKS ALREADY
        return $this->belongsTo(User::class, "vendor_id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
