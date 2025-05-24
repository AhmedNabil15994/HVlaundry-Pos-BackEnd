<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Translatable\HasTranslations;

class StarchType extends Model
{
    use HasTranslations, ScopesTrait, SoftDeletes;

    protected $table = 'starch_types';
    protected $guarded = ["id"];
    public $translatable = ['title'];
    public $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return url($this->image);
    }
}
