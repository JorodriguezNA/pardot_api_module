<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PardotModulePardotapiCreateInstancesStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'instances',
         'title_column' => 'name',
         'translatable' => true,
         'trashable' => false,
         'searchable' => false,
         'sortable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => [
            'translatable' => false,
            'required' => true,
        ],
        'account_email' => [
            'translatable' => false,
            'required' => true,
        ],
        'user_password' => [
            'translatable' => false,
            'required' => true,
        ],
        'user_key' => [
            'translatable' => false,
            'required' => true,
        ],
        'rest_domain' => [
            'translatable' => false,
            'required' => true,
        ],
        'slug' => [
            'unique' => true,
            'required' => true,
        ],
    ];

}
