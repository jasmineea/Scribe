<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use HasFactory;
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'orders';

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

    public function listing()
    {
        return $this->belongsTo('Modules\Listing\Entities\Listing', 'listing_id', 'id');
    }
}
