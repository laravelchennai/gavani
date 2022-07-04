<?php

namespace App\Models\Monitoring;

use App\Models\User;
use App\Models\BaseModel;
use App\Observers\SiteObserver;
use App\Models\Concerns\TimeStamp;
use App\Models\Concerns\UserStamp;
use App\Models\Scans\SslCertificateScan;
use App\Models\Concerns\ActivityLogStamp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends BaseModel
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
        'is_domain_valid' => 'boolean',
        'check_ssl' => 'boolean',
        'check_domain' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'friendly_name',
        'is_domain_valid',
        'check_ssl',
        'check_domain',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the User that Created the Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the User that Updated the Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Get all of the SslCertificateScans for the Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sslCertificateScans(): HasMany
    {
        return $this->hasMany(SslCertificateScan::class, 'site_id', 'id');
    }

    /**
     * Get the Site's most recent SslCertificateScan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestSslCertificateScan(): HasOne
    {
        return $this->hasOne(SslCertificateScan::class, 'site_id', 'id')->latestOfMany();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::observe(SiteObserver::class);
    }
}
