<?php
declare(strict_types=1);

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\MagicLinkController as ShieldMagicLinkController;
use CodeIgniter\HTTP\RedirectResponse;

class MagicLinkController extends ShieldMagicLinkController
{
    /**
     * Displays the form to log in to the site.
     *
     * @return RedirectResponse|string
     */
    public function loginView()
    {
        if (! setting('Auth.allowMagicLinkLogins')) {
            return redirect()->route('login')->with('error', lang('Auth.magicLinkDisabled'));
        }

        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        $data = [
            'title' => 'Login - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
        ];

        return $this->view(setting('Auth.views')['magic-link-login'], $data);
    }

    public function testDebug()
    {
        echo "This is a test debug method";
    }
}