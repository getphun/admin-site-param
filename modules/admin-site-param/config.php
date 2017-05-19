<?php
/**
 * admin-site-param config file
 * @package admin-site-param
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'admin-site-param',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/admin-site-param',
    '__files' => [
        'modules/admin-site-param' => [ 'install', 'remove', 'update' ],
        'theme/admin/setting/params' => [ 'install', 'remove', 'update' ],
        'theme/admin/static/js/site-param.js' => [ 'install', 'remove', 'update' ]
    ],
    '__dependencies' => [
        'admin',
        'site-param'
    ],
    '_services' => [],
    '_autoload' => [
        'classes' => [
            'AdminSiteParam\\Controller\\SettingController'    => 'modules/admin-site-param/controller/SettingController.php',
        ],
        'files' => []
    ],
    
    '_routes' => [
        'admin' => [
            'adminSettingParams' => [
                'rule' => '/setting/params',
                'handler' => 'AdminSiteParam\\Controller\\Setting::index'
            ],
            'adminSettingParamsEdit' => [
                'rule' => '/setting/params/:id',
                'handler' => 'AdminSiteParam\\Controller\\Setting::edit'
            ],
            'adminSettingParamsRemove' => [
                'rule' => '/setting/params/:id/remove',
                'handler' => 'AdminSiteParam\\Controller\\Setting::remove'
            ]
        ]
    ],
    
    'admin' => [
        'menu' => [
            'setting' => [
                'label'     => 'Setting',
                'icon'      => 'cogs',
                'order'     => 10000,
                'submenu'   => [
                    'params'    => [
                        'label'     => 'Params',
                        'perms'     => 'read_setting',
                        'target'    => 'adminSettingParams',
                        'order'     => 100
                    ]
                ]
            ]
        ]
    ],
    
    'form' => [
        'admin-setting-params-create' => [
        
            'name' => [
                'type'      => 'text',
                'label'     => 'Name',
                'desc'      => 'Use only character a-z, 0-9, and _',
                'rules'     => [
                    'regex'     => '!^([a-z0-9_]+)$!',
                    'required'  => true
                ]
            ],
            
            'group' => [
                'type'      => 'text',
                'label'     => 'Group',
                'rules'     => [
                    'required' => true
                ]
            ],
            
            'type' => [
                'type'      => 'select',
                'label'     => 'Type',
                'options'   => [
                    1   => 'Text',
                    2   => 'Date',
                    3   => 'Number',
                    4   => 'Boolean',
                    5   => 'Multiline',
                    6   => 'URL',
                    7   => 'Email',
                    8   => 'Color'
                ],
                'rules'     => [
                    'required' => true
                ]
            ],
        ],
        
        'admin-setting-params-edit' => [
        
            'name' => [
                'type'      => 'text',
                'label'     => 'Name',
                'desc'      => 'Use only character a-z, 0-9, and _',
                'rules'     => [
                    'regex'     => '!^([a-z0-9_]+)$!',
                    'required'  => true,
                    'unique' => [
                        'model' => 'SiteParam\\Model\\SiteParam',
                        'field' => 'name',
                        'self'  => [
                            'uri'   => 'id',
                            'field' => 'id'
                        ]
                    ]
                ]
            ],
            
            'group' => [
                'type'      => 'text',
                'label'     => 'Group',
                'rules'     => [
                    'required' => true
                ]
            ],
            
            'value' => [
                'type'      => 'text',
                'label'     => 'Value',
                'rules'     => []
            ]
        ]
    ]
];