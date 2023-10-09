<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDesign extends Model
{
    use HasFactory;
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'card_designs';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user of a UserProvider.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
