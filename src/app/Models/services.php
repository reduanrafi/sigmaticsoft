<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model {
    use HasFactory;
    use CommonFunctions;
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active',
    ];

    public function GetData($data) {

        if (isset($data['image'])) {

            $data['image'] = $this->UploadImage($data['image'], 'services');

        }

        return $data;
    }
}
