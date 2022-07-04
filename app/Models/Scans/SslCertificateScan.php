<?php

namespace App\Models\Scans;

use App\Models\BaseModel;
use App\Models\Concerns\ActivityLogStamp;
use App\Models\Concerns\TimeStamp;
use App\Models\Concerns\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SslCertificateScan extends BaseModel
{
    use ActivityLogStamp;
    use HasFactory;
    use SoftDeletes;
    use TimeStamp;
    use UserStamp;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'additional_domains' => 'array',
        'valid_from' => 'datetime',
        'valid_till' => 'datetime',
        'is_ssl_certificate_valid' => 'boolean',
        'is_ssl_certificate_expired' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'issued_by',
        'domain_name',
        'additional_domains',
        'valid_from',
        'valid_till',
        'is_ssl_certificate_valid',
        'is_ssl_certificate_expired',
    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the User that Created the SslCertificateScan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }


    /**
     * Get the User that Updated the SslCertificateScan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
