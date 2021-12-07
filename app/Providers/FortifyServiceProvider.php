<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return abort(404);
            // return view('auth.register');
        });

        Fortify::RequestPasswordResetLinkView(function () {
            return view('auth.passwords.forgot-password');
        });

        Fortify::ResetPasswordView(function ($request) {
            return view('auth.passwords.reset', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify');
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });

        //authentication
        Fortify::authenticateUsing(function (Request $request) {
            // $captcha_enable= Configuration::where('key','captcha_enable')->first();
            // $captcha_login= Configuration::where('key','captcha_login')->first();
            // if ($captcha_enable) {
            //     $captcha_enable = $captcha_enable->value;
            //     if ($captcha_enable) {
            //         if ($captcha_login) {
            //             $captcha_login = $captcha_login->value;
            //             if ($captcha_login) {
            //                 $request->validate([
            //                     'g-recaptcha-response' => [
            //                         'required',
            //                         new Recaptcha()
            //                     ],
            //                 ]);
            //             }
            //         }
            //     }
            // }
            $user = User::where('email', $request->email)->first();
            // $usermail = User::where('email', $request->username)->first();
            // $user = $user ? $user : $usermail;

            if ($user && Hash::check($request->password, $user->password)) {
                    $user->update([
                        'last_login_at' => Carbon::now()->toDateTimeString(),
                        'last_login_ip' => $request->getClientIp()
                    ]);
                    //log information on logins table
                    $browser_info = getBrowser();
                    $session_id = session()->getId();

                    // $login_log = UserLoginLog::create([
                    //     'user_id' => $user->id,
                    //     'last_login_ip' => $request->getClientIp(),
                    //     'browser_info' => json_encode($browser_info),
                    //     'session_id' => $session_id,
                    // ]);

                return $user;
            }
        });
    }
}
