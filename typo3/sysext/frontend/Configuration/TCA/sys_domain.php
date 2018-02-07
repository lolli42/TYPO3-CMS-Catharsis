<?php
return [
    'ctrl' => [
        'label' => 'domainName',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:sys_domain',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'typeicon_classes' => [
            'default' => 'mimetypes-x-content-domain'
        ],
        'searchFields' => 'domainName'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,domainName'
    ],
    'columns' => [
        'domainName' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:sys_domain.domainName',
            'config' => [
                'type' => 'input',
                'size' => 35,
                'max' => 255,
                'eval' => 'required,unique,lower,trim,domainname',
                'softref' => 'substitute'
            ]
        ],
        'hidden' => [
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.disable',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    domainName,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
    'palettes' => [
    ]
];
