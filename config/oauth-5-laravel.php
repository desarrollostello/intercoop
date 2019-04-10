<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',
    //'storage' => 'Session',

    /**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => '179436585569928',
			'client_secret' => '3f17d5782df10755dc3f0ced2ea070c4',
			'scope'         => ['email','user_photos','public_profile','user_about_me','user_birthday'],
		],
        'Google' => [
            'client_id'     => '874747489048-8m78t99dka6lpkund58vfbs6udgkh6q9.apps.googleusercontent.com',
            'client_secret' => 'B3AmZqPdeXWAH6Sinhi2NMM0',
            'scope'         => ['userinfo_email', 'userinfo_profile'],
        ],
    ]

];