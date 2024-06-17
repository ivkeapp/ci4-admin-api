<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\RedirectResponse;

class RegisterController extends ShieldRegister
{
    /**
     * Displays the registration form.
     *
     * @return RedirectResponse|string
     */
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        $data = [
            'title' => 'Registration - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
        ];

        return $this->view(setting('Auth.views')['register'], $data);
    }
}