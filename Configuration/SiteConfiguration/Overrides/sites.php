<?php

call_user_func(
    static function () {
        $lll = 'LLL:EXT:friendlycaptcha_official/Resources/Private/Language/Configuration.xlf:';
        $GLOBALS['SiteConfiguration']['site']['columns']['friendlycaptcha_site_key'] = [
            'label' => $lll . 'site.configuration.site_key',
            'config' => [
                'type' => 'input',
                'placeholder' => 'FCMTC9U033GFFJI6',
            ],
        ];
        $GLOBALS['SiteConfiguration']['site']['columns']['friendlycaptcha_secret_key'] = [
            'label' => $lll . 'site.configuration.secret_key',
            'config' => [
                'type' => 'input',
                'placeholder' => 'A16UE6NICBMVQKG1I1BFMLBD56K53D3CS0L5N00AJNBT1R41P8O7N1KFMH',
            ],
        ];
        $GLOBALS['SiteConfiguration']['site']['columns']['friendlycaptcha_puzzle_endpoint'] = [
            'label' => $lll . 'site.configuration.puzzle_endpoint',
            'config' => [
                'type' => 'input',
                'placeholder' => 'eu',
                'default' => '',
            ],
        ];
        $GLOBALS['SiteConfiguration']['site']['columns']['friendlycaptcha_verify_url'] = [
            'label' => $lll . 'site.configuration.verify_url',
            'config' => [
                'type' => 'input',
                'placeholder' => 'https://global.frcapi.com/api/v2/captcha/siteverify',
                'default' => 'https://global.frcapi.com/api/v2/captcha/siteverify',
            ],
        ];
        $GLOBALS['SiteConfiguration']['site']['columns']['friendlycaptcha_js_path'] = [
            'label' => $lll . 'site.configuration.js_path',
            'config' => [
                'type' => 'input',
                'placeholder' => \StudioMitte\FriendlyCaptcha\Configuration::DEFAULT_JS_PATH,
                'default' => \StudioMitte\FriendlyCaptcha\Configuration::DEFAULT_JS_PATH,
            ],
        ];
        $GLOBALS['SiteConfiguration']['site']['columns']['friendlycaptcha_skip_dev_validation'] = [
            'label' => $lll . 'site.configuration.skip_dev_validation',
            'description' => $lll . 'site.configuration.skip_dev_validation.description',
            'config' => [
                'type' => 'check',
            ],
        ];
        $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',--div--;' . $lll . 'site.configuration.tab, friendlycaptcha_site_key,friendlycaptcha_secret_key,friendlycaptcha_puzzle_endpoint,friendlycaptcha_verify_url,friendlycaptcha_js_path,friendlycaptcha_skip_dev_validation,';
    }
);
