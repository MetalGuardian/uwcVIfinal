<?php
$main = require(__DIR__ . '/../../common/config/main.php');
$frontend = array(
	'id' => 'melon-frontend',
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
	'name' => '',
	'aliases' => array(
		'frontend' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'front' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'front'
		),
		'translate' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'translate'
		),
		'menu' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'menu'
		),
		'seo' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'seo'
		),
		'language' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'language'
		),
		'news' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'news'
		),
		'configuration' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'configuration'
		),
		'emailQueue' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'emailQueue'
		),
		'event' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'event'
		),
	),
	'theme' => 'melon',
	'modules' => array(
		'front' => array(
			'class' => '\front\FrontModule',
		),
		'file-processor' => array(
			'class' => '\fileProcessor\FileProcessorModule',
			'baseDir' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www') . DIRECTORY_SEPARATOR,
			'originalBaseDir' => 'uploads',
			'cachedImagesBaseDir' => 'uploads/thumb',
			// set path without first and last slashes
			'imageSections' => array(
				'event' => array(
					'widget' => array(
						'width' => 120,
						'height' => 120,
						'quality' => 100,
						'do' => 'adaptiveResize', // resize|adaptiveResize
					),
				),
			),
			'imageHandler' => array(
				'driver' => '\fileProcessor\extensions\imageHandler\drivers\MDriverGD',
				// '\fileProcessor\extensions\imageHandler\drivers\MDriverImageMagic'
			),
		),
		'menu' => array(
			'class' => '\menu\MenuModule',
		),
		'news' => array(
			'class' => '\news\NewsModule',
		),
		'configuration' => array(
			'class' => '\configuration\ConfigurationModule',
		),
		'event' => array(
			'class' => '\event\EventModule',
		),
	),
	'controllerNamespace' => '\frontend\controllers',
	'controllerMap'=>array(
		'image' => array(
			'class'=>'\fileProcessor\controllers\ImageController',
		),
	),
	'components' => array(
		'themeManager' => array(
			'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'themes'),
		),
		'urlManager' => array(
			'class' => '\language\components\LanguageUrlManager',
			'defaultLanguage' => 'ru',
			'urlFormat' => 'path',
			'showScriptName' => false,
			'useStrictParsing' => true,
			'exclude' => array('gii', 'image'),
			'rules' => array(
				/*array(
					'route1',
					'pattern' => 'pattern1',
					'urlSuffix' => '.xml',
					'caseSensitive' => false | true,
					'defaultParams' => array(
						'param1' => 'value1',
					),
					'matchValue' => false | true | null,
					'verb' => 'POST,GET,DELETE' | null,
					'parsingOnly' => false | true,
				),*/
				array('site/index', 'pattern' => '<lang:\w{2}>'),
				array('site/index', 'pattern' => ''),
				array('site/success', 'pattern' => 'success'),

				array('site/imperaviImageUpload', 'pattern' => '<lang:\w{2}>/redactor/upload/image', ),
				array('site/imperaviImageUpload', 'pattern' => 'redactor/upload/image', ),
				array('site/imperaviFileUpload', 'pattern' => '<lang:\w{2}>/redactor/upload/file', ),
				array('site/imperaviFileUpload', 'pattern' => 'redactor/upload/file', ),

				array('event/default/index', 'pattern' => 'event'),
				array('event/default/view', 'pattern' => 'event/<id:\d+>'),
				array('event/default/buy', 'pattern' => 'event/<id:\d+>/buy'),
				array('event/default/ticket', 'pattern' => 'event/ticket/<hash:\w+>'),

				array(
					'class' => '\fileProcessor\components\YiiFileProcessorUrlRule',
					'connectionId' => 'db',
					'cacheId' => 'cache',
					'controllerId' => 'image',
				),

				// gii
				array('gii', 'pattern' => 'gii'),
				array('gii/<controller>', 'pattern' => 'gii/<controller:\w+>'),
				array('gii/<controller>/<action>', 'pattern' => 'gii/<controller:\w+>/<action:\w+>'),
			),
		),
		'user' => array(
			'class' => '\front\components\WebUser',
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'autoRenewCookie' => true,
			'identityCookie' => array(
				'path' => '/',
				//'domain' => '.example.com'
			),
		),
		'request' => array(
			'class' => '\front\components\HttpRequest',
			'enableCookieValidation' => true,
			'enableCsrfValidation' => true,
			'csrfCookie' => array(
				'httpOnly' => true,
			),
			'noCsrfValidationUrls' => array(),
		),
		'clientScript' => array(
			'class' => '\core\components\ClientScript',
			'packages' => array(
				'frontend.main' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/application.js',
					),
					'css' => array(
						'css/application.css' => 'screen, projection',
					),
					'depends' => array('jquery', 'theme.melon', 'fonts'),
				),
				'theme.melon' => array(
					'baseUrl' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/',
					'js' => array(
						'js/bootstrap.min.js',
					),
					'css' => array(
						'css/bootstrap.min.css' => '',
					),
					'depends' => array('jquery', ),
				),
				'fonts' => array(
					'baseUrl' => '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/',
					'css' => array(
						'/css/font-awesome.min.css' => '',
					),
					'depends' => array('jquery', ),
				),
				'frontend2.main' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/application.js',
					),
					'css' => array(
						'css/application2.css' => 'screen, projection',
					),
					'depends' => array('jquery', 'theme.melon3.2'),
				),
				'theme.melon3.2' => array(
					'baseUrl' => '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/',
					'js' => array(
						'js/bootstrap.min.js',
					),
					'css' => array(
						'css/bootstrap.min.css' => '',
					),
					'depends' => array('jquery', ),
				),
			),
			'scriptMap' => array(
				'jquery.js' => '//code.jquery.com/jquery-1.10.2.min.js',
				'jquery.min.js' => '//code.jquery.com/jquery-1.10.2.min.js',
			),
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'session' => array(
			'class' => '\front\components\DbHttpSession',
			'connectionID' => 'db',
			'autoStart' => true,
			'cookieMode' => 'allow',
			'timeout' => 60*60*24*30,
			'cookieParams' => array(
				'path' => '/',
				'example' => '.example.com',
				'httpOnly' => true,
			),
			'sessionTableName' => '{{yii_session}}',
			'autoCreateSessionTable' => false,
		),
		'config' => array(
			'class' => '\configuration\components\ConfigurationComponent',
		),
	),
);

$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \mergeArray(
	\mergeArray(
		$main,
		$frontend
	),
	$local
);
