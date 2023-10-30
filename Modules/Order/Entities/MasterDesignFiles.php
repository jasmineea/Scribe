<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDesignFiles extends Model
{
    use HasFactory;
    use HasFactory;
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'master_design_files';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    // /**
    //  * Get the user of a UserProvider.
    //  */
    // public function listingMeta()
    // {
    //     return $this->hasMany('Modules\Listing\Entities\Contact');
    // }
}
