<?php

return array(
		
	'toy\services\Agent' => array(
			
		// Browsers
		'browsers' => array(

				'Trident/7.0'		=> 'IE11',
				'Trident/6.0'		=> 'IE10',
				'Trident/5.'		=> 'IE9',
				'Trident/4.0'		=> 'IE8',
				'Flock'				=> 'Flock',
				'Chrome'			=> 'Chrome',
				'Opera'				=> 'Opera',
				'MSIE'				=> 'Internet Explorer',
				'Internet Explorer'	=> 'Internet Explorer',
				'Shiira'			=> 'Shiira',
				'Firefox'			=> 'Firefox',
				'Chimera'			=> 'Chimera',
				'Phoenix'			=> 'Phoenix',
				'Firebird'			=> 'Firebird',
				'Camino'			=> 'Camino',
				'Netscape'			=> 'Netscape',
				'OmniWeb'			=> 'OmniWeb',
				'Safari'			=> 'Safari',
				'Mozilla'			=> 'Mozilla',
				'Konqueror'			=> 'Konqueror',
				'icab'				=> 'iCab',
				'Lynx'				=> 'Lynx',
				'Links'				=> 'Links',
				'hotjava'			=> 'HotJava',
				'amaya'				=> 'Amaya',
				'IBrowse'			=> 'IBrowse',
				'Console'			=> 'Console',
		),

		// Mobiles
		'mobiles' => array(

				// legacy array, old values commented out
				'mobileexplorer'		=> 'Mobile Explorer',
				'palmsource'			=> 'Palm',
				'palmscape'				=> 'Palmscape',

				// Phones and Manufacturers
				'motorola'				=> "Motorola",
				'nokia'					=> "Nokia",
				'palm'					=> "Palm",
				'iphone'				=> "Apple iPhone",
				'ipad'					=> "iPad",
				'ipod'					=> "Apple iPod Touch",
				'sony'					=> "Sony Ericsson",
				'ericsson'				=> "Sony Ericsson",
				'blackberry'			=> "BlackBerry",
				'cocoon'				=> "O2 Cocoon",
				'blazer'				=> "Treo",
				'lg'					=> "LG",
				'amoi'					=> "Amoi",
				'xda'					=> "XDA",
				'mda'					=> "MDA",
				'vario'					=> "Vario",
				'htc'					=> "HTC",
				'samsung'				=> "Samsung",
				'sharp'					=> "Sharp",
				'sie-'					=> "Siemens",
				'alcatel'				=> "Alcatel",
				'benq'					=> "BenQ",
				'ipaq'					=> "HP iPaq",
				'mot-'					=> "Motorola",
				'playstation portable'	=> "PlayStation Portable",
				'hiptop'				=> "Danger Hiptop",
				'nec-'					=> "NEC",
				'panasonic'				=> "Panasonic",
				'philips'				=> "Philips",
				'sagem'					=> "Sagem",
				'sanyo'					=> "Sanyo",
				'spv'					=> "SPV",
				'zte'					=> "ZTE",
				'sendo'					=> "Sendo",

				// Operating Systems
				'symbian'				=> "Symbian",
				'SymbianOS'				=> "SymbianOS",
				'elaine'				=> "Palm",
				'palm'					=> "Palm",
				'series60'				=> "Symbian S60",
				'windows ce'			=> "Windows CE",

				// Browsers
				'obigo'					=> "Obigo",
				'netfront'				=> "Netfront Browser",
				'openwave'				=> "Openwave Browser",
				'mobilexplorer'			=> "Mobile Explorer",
				'operamini'				=> "Opera Mini",
				'opera mini'			=> "Opera Mini",
				'opera mobi'			=> "Opera Mobi",

				// Other
				'digital paths'			=> "Digital Paths",
				'avantgo'				=> "AvantGo",
				'xiino'					=> "Xiino",
				'novarra'				=> "Novarra Transcoder",
				'vodafone'				=> "Vodafone",
				'docomo'				=> "NTT DoCoMo",
				'o2'					=> "O2",

				// Fallback
				'mobile'				=> "Generic Mobile",
				'wireless'				=> "Generic Mobile",
				'j2me'					=> "Generic Mobile",
				'midp'					=> "Generic Mobile",
				'cldc'					=> "Generic Mobile",
				'up.link'				=> "Generic Mobile",
				'up.browser'			=> "Generic Mobile",
				'smartphone'			=> "Generic Mobile",
				'cellphone'				=> "Generic Mobile"
		),

		// Platforms
		'platforms' => array(

				'windows nt 6.3'	=> "Windows 8.1",
				'windows nt 6.2'	=> "Windows 8",
				'windows nt 6.1'	=> "Windows 7",
				'windows nt 6.0'	=> "Windows Vista",
				'windows nt 5.2'	=> "Windows Server 2003; Windows XP x64 Edition",
				'windows nt 5.1'	=> "Windows XP",
				'windows nt 5.01'	=> "Windows 2000, Service Pack 1 (SP1)",
				'windows nt 5.0'	=> "Windows 2000",
				'windows nt 4.0'	=> "Microsoft Windows NT 4.0",
				'windows 98'		=> "Windows 98",
				'windows 95'		=> "Windows 95",
				'windows ce'		=> "Windows CE",
				'windows'			=> 'Unknown Windows OS',
				'os x'				=> 'Mac OS X',
				'ppc mac'			=> 'Power PC Mac',
				'freebsd'			=> 'FreeBSD',
				'ppc'				=> 'Macintosh',
				'linux'				=> 'Linux',
				'debian'			=> 'Debian',
				'sunos'				=> 'Sun Solaris',
				'beos'				=> 'BeOS',
				'apachebench'		=> 'ApacheBench',
				'aix'				=> 'AIX',
				'irix'				=> 'Irix',
				'osf'				=> 'DEC OSF',
				'hp-ux'				=> 'HP-UX',
				'netbsd'			=> 'NetBSD',
				'bsdi'				=> 'BSDi',
				'openbsd'			=> 'OpenBSD',
				'gnu'				=> 'GNU/Linux',
				'unix'				=> 'Unknown Unix OS'
		),

		// Robots
		'robots' => array(

				'googlebot'			=> 'Googlebot',
				'msnbot'			=> 'MSNBot',
				'bingbot'           => 'bingbot',
				'slurp'				=> 'Inktomi Slurp',
				'yahoo'				=> 'Yahoo',
				'askjeeves'			=> 'AskJeeves',
				'fastcrawler'		=> 'FastCrawler',
				'infoseek'			=> 'InfoSeek Robot 1.0',
				'lycos'				=> 'Lycos',
				'yandex'			=> 'Yandex',
				'yandexbot'         => 'YandexBot',
				'majestic12'        => 'MJ12bot',
				'baidu'             => 'Baiduspider',
				'ahrefs'            => 'AhrefsBot',
		),
	),
);

