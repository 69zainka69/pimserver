<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
	protected $table = 'product';
    protected $fillable = ['name','descr_prote_ru','descr_prote', 'updated_at', 'created_at','name_en_us','long_description_en_us','long_description', 'brand_id', 'ean', 'sku', 'uvp', 'price','amount', 'producer'];
    //
}
