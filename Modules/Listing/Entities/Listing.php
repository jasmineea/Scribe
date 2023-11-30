<?php

namespace Modules\Listing\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'listings';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    /**
     * Get all of the users that are assigned this list.
     */
    public function contacts()
    {
        return $this->hasMany('Modules\Listing\Entities\Contact');
    }

    // /**
    //  * Set the 'meta title'.
    //  * If no value submitted use the 'Title'.
    //  *
    //  * @param [type]
    //  */
    // public function setMetaTitleAttribute($value)
    // {
    //     $this->attributes['meta_title'] = $value;

    //     if (empty($value)) {
    //         $this->attributes['meta_title'] = $this->attributes['name'];
    //     }
    // }

    // /**
    //  * Set the 'meta description'
    //  * If no value submitted use the default 'meta_description'.
    //  *
    //  * @param [type]
    //  */
    // public function setMetaDescriptionAttribute($value)
    // {
    //     $this->attributes['meta_description'] = $value;

    //     if (empty($value)) {
    //         $this->attributes['meta_description'] = setting('meta_description');
    //     }
    // }

    // /**
    //  * Set the 'meta description'
    //  * If no value submitted use the default 'meta_description'.
    //  *
    //  * @param [type]
    //  */
    // public function setMetaKeywordAttribute($value)
    // {
    //     $this->attributes['meta_keyword'] = $value;

    //     if (empty($value)) {
    //         $this->attributes['meta_keyword'] = setting('meta_keyword');
    //     }
    // }

    // /**
    //  * Create a new factory instance for the model.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Factories\Factory
    //  */
    // protected static function newFactory()
    // {
    //     return \Modules\Tag\Database\Factories\TagFactory::new();
    // }
}
