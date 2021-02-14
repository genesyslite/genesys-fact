<?php

return [
    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `GenesysLite\GenesysFact\Models\User` contract.
         */

        'user' => \App\Models\User::class,


    ],
    'configuration_sunat' => [
        [
            'field' => 'send_auto',
            'value' => true,
            'type' => 'Configuration'
        ],
        [
            'field' => 'locked_emission',
            'value' => false,
            'type' => 'Configuration'
        ],
        [
            'field' => 'locked_tenant',
            'value' => false,
            'type' => 'Configuration'
        ],
        [
            'field' => 'locked_users',
            'value' => false,
            'type' => 'Configuration'
        ],
        [
            'field' => 'limit_documents',
            'value' => 10000,
            'type' => 'Configuration'
        ],
        [
            'field' => 'limit_users',
            'value' => 10000,
            'type' => 'Configuration'
        ],
        [
            'field' => 'date_time_start',
            'value' => date('Y-m-d H:i:s'),
            'type' => 'Configuration'
        ],
        [
            'field' => 'quantity_documents',
            'value' => 0,
            'type' => 'Configuration'
        ],
        [
            'field' => 'config_system_env',
            'value' => false,
            'type' => 'Configuration'
        ],

        [
            'field' => 'soap_send_id',
            'value' => '01',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'soap_type_id',
            'value' => '01',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'soap_username',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'soap_password',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'soap_url',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'certificate',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'certificate_due',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'logo',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'logo_store',
            'value' => '',
            'type' => 'SUNAT'
        ],
        [
            'field' => 'operation_amazonia',
            'value' => '',
            'type' => 'SUNAT'
        ]
    ],
];
