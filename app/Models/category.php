<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'categories';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    // Define the relationship to the Menu model
    public function menuItems()
    {
        return $this->hasMany(Menu::class, 'category_id');
    }
}
