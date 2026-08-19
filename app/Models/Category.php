<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'description', 'image', 'is_active', 'sort_order'])]
#[Hidden([])]
class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            $base = Str::slug($category->name);

            $slug = $base;
            $i = 2;

            while (static::where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->exists()) {
                $slug = $base.'-'.$i++;
            }

            $category->slug = $slug;
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
