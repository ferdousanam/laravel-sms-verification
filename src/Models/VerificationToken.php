<?php

namespace Anam\SmsVerification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VerificationToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    /**
     * Get the tokenable model that the access token belongs to.
     *
     * @return MorphTo
     */
    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }
}
