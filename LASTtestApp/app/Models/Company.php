<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_kana',
        'address', 
        'tel', 
        'representative_name', 
        'representative_name_kana',
    ];

    public function billing(): HasOne
    {
        return $this->hasOne(CompanyBilling::class);
    }

    protected static function booted()
    {
        static::deleting(function ($company) {
            $company->billing()->delete();
        });
    }
}