<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GroupFilter implements FilterInterface
{
    protected $user;
    protected $auth;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->auth = service('auth');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$this->auth->loggedIn()) {
            log_message('debug', 'User not logged in, redirecting to login.');
            return redirect()->route('login');
        }
        log_message('debug', 'User id: '.$this->auth->id());
        
        log_message('debug', 'Checking user group for access.');
        
        if (!empty($arguments)) {
            $userData = $this->user->find($this->auth->id());
            // $userData->syncGroups('admin');
            foreach ($arguments as $group) {
                
                log_message('debug', "Checking group: {$group}");
                // print_r($group);
                // echo '<br>group ';

                // print_r($userData);

                // echo '<br>getPermissions ';
                // print_r($userData->getPermissions());

                // echo '<br>getGroups ';
                // print_r($userData->getGroups());

                // echo '<br>isActivated ';
                // print_r($userData->isActivated());

                // echo '<br>inGroup ';
                // print_r($userData->inGroup('admin'));

                // echo '<br>';
                // echo 'Group: '.$group;
                // echo '<br>';

                if ($userData->inGroup($group)) {
                    log_message('debug', "User is in group: {$group}");
                    return; // User is authorized, continue execution
                } else {
                    log_message('debug', "User is NOT in group: {$group}");
                }
            }
        } else {
            log_message('debug', 'Arguments not found!');
        }

        log_message('debug', 'User is not in the required group(s), redirecting to no access page.');
        return redirect()->to('/no-access');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here after processing
    }
}
