<?php

namespace Anam\SmsVerification;

use Anam\SmsVerification\Models\VerificationToken;
use Illuminate\Contracts\Auth\Authenticatable;

trait HasVerificationTokens
{
    /**
     * Get the verification tokens that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function verificationTokens()
    {
        return $this->morphMany(VerificationToken::class, 'tokenable');
    }

    /**
     * Create a new verification token for the user.
     *
     * @param int $length
     * @return Authenticatable
     */
    public function createVerificationToken(int $length = 4)
    {
        return $this->verificationTokens()->create([
            'token' => substr(str_shuffle('0123456789'), 0, $length),
        ]);
    }

    /**
     * Check the verification token for the user.
     *
     * @param string $token
     * @return boolean
     */
    public function isValidToken($token)
    {
        if ($token = $this->verificationTokens()->where(['token' => $token])->first()) {
            $token->delete();
            return true;
        }

        return false;
    }
}
