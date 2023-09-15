<?php

namespace Modules\Order\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterFiles extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'master_files';

}
