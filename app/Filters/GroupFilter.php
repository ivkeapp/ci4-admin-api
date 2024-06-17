<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GroupFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // echo 'hello group filter';
        $auth = service('auth');

        if (!$auth->loggedIn()) {
            log_message('debug', 'User not logged in, redirecting to login.');
            return redirect()->route('login');
        }

        // Log group check
        log_message('debug', 'Checking user group for access.');

        if (!empty($arguments)) {
            foreach ($arguments as $group) {
                if ($auth->inGroup($group)) {
                    log_message('debug', "User is in group: {$group}");
                    return;
                }
            }
        }

        log_message('debug', 'User is not in the required group(s), redirecting to no access page.');
        return redirect()->to('/no-access');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
