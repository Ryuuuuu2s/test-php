<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBilling extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_kana',
        'address',
        'tel',
        'department',
        'billing_name',
        'billing_name_kana',
    ];

    protected $dates = ['deleted_at'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}