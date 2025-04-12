<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class images extends Model
{
    //
    protected $fillable = ['image', 'location', 'belongsTo', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
