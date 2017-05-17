<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Link Validator',
    'description' => 'Link Validator checks the links in your website for validity. It can validate all kinds of links: internal, external and file links. Scheduler is supported to run Link Validator via Cron including the option to send status mails, if broken links were detected.',
    'category' => 'module',
    'author' => 'Jochen Rieger / Dimitri König / Michael Miousse',
    'author_email' => 'j.rieger@connecta.ag, mmiousse@infoglobe.ca',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author_company' => 'Connecta AG / cab services ag / Infoglobe',
    'version' => '9.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.0.0-9.0.99',
            'info' => '9.0.0-9.0.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
