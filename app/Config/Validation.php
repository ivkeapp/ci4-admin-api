<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $registration = [
        'username' => [
            'label' => 'Auth.username',
            'rules' => [
                'required',
                'max_length[30]',
                'min_length[3]',
                'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                'is_unique[users.username]',
            ],
        ],
        'mobile_phone' => [
            'label' => 'Mobile Number',
            'rules' => [
                'max_length[20]',
                'min_length[8]',
                'regex_match[/\A[0-9]+\z/]',
                'is_unique[users.mobile_phone]',
            ],
        ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
        'address' => [
            'label' => 'Address',
            'rules' => [
                'required',
                'min_length[5]',
            ],
        ],
        'first_name' => [
            'label' => 'First Name',
            'rules' => [
                'required',
                'min_length[2]',
            ],
        ],
        'last_name' => [
            'label' => 'Last Name',
            'rules' => [
                'required',
                'min_length[2]',
            ],
        ],
    ];

    public array $blogRules = [
        'seo_title' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'The seo title field is required',
                'min_length' => 'The seo title field must be at least 3 characters in length.',
                'max_length' => 'The seo title field must be not greater than 255 characters in length.',
            ],
        ],
        'seo_description' => [
            'rules' => 'required|min_length[5]|max_length[255]',
            'errors' => [
                'required' => 'The seo description field is required',
                'min_length' => 'The seo description field must be at least 5 characters in length.',
                'max_length' => 'The seo description field must be not greater than 255 characters in length.',
            ],
        ],
        'title' => 'required|min_length[3]|max_length[255]',
        'subtitle' => 'required|min_length[3]|max_length[255]',
        'content' => 'required|min_length[10]|max_length[1000]',
        'image' => [
            'label' => 'Image File',
            'rules' => [
                'uploaded[image]',
                'is_image[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                'max_size[image,10000]',
                'max_dims[image,1920,1080]',
            ],
        ],
    ];

    public array $blogRulesUpdate = [
        'seo_title' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'The seo title field is required',
                'min_length' => 'The seo title field must be at least 3 characters in length.',
                'max_length' => 'The seo title field must be not greater than 255 characters in length.',
            ],
        ],
        'seo_description' => [
            'rules' => 'required|min_length[5]|max_length[255]',
            'errors' => [
                'required' => 'The seo description field is required',
                'min_length' => 'The seo description field must be at least 5 characters in length.',
                'max_length' => 'The seo description field must be not greater than 255 characters in length.',
            ],
        ],
        'title' => 'required|min_length[3]|max_length[255]',
        'subtitle' => 'required|min_length[3]|max_length[255]',
        'content' => 'required|min_length[10]|max_length[1000]',
        'image' => [
            'label' => 'Image File',
            'rules' => [
                'is_image[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                'max_size[image,10000]',
                'max_dims[image,1920,1080]',
            ],
        ],
    ];

}
