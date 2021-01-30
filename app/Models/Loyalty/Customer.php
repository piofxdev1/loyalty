<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Loyalty\Reward;

class Customer extends Model
{
    use HasFactory;

    public function rewards(){
        return $this->hasMany(Reward::class);
    }
}
