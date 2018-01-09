<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PardotModulePardotapiCreatePardotapiFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name' => 'anomaly.field_type.text',
        'account_email' => [
            'type' => 'anomaly.field_type.email',
        ],
        'user_password' => [
            'type'      => 'anomaly.field_type.encrypted',
           
        ],
        'user_key' => [
            'type'      => 'anomaly.field_type.encrypted',
            
        ],
        'rest_domain' => [
            'type'      => 'anomaly.field_type.text',
        ],
        'slug' => [
            'type' => 'anomaly.field_type.text',
            'config' => [
                'slugify' => 'name',
                'type' => '_'
            ],
        ],
    ];

}
