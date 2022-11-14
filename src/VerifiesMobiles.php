<?php

namespace Anam\SmsVerification;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait VerifiesMobiles
{
    use RedirectsUsers;

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedMobile()
                        ? redirect($this->redirectPath())
                        : view('auth.sms-verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $this->validate($request, [
            'otp' => ['required', 'digits:4'],
        ]);

        if (!$request->user()->isValidToken($request->input('otp'))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedMobile()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect($this->redirectPath());
        }

        if ($request->user()->markMobileAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect($this->redirectPath())->with('sms-verified', true);
    }

    /**
     * The user has been verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        //
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedMobile()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect($this->redirectPath());
        }

        $request->user()->sendMobileVerificationNotification();

        return $request->wantsJson()
                    ? new JsonResponse([], 202)
                    : back()->with('resent-otp', true);
    }
}
