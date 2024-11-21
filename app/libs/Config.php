<?php	
/**
 * Config
 * development
 * production
 * testing
 */
class Config
{
	
	function __construct($ambiente)
	{
		setlocale(LC_MONETARY, 'es_MX');
		date_default_timezone_set('America/Mexico_City');
		switch ($ambiente)
		{
			case 'development':
				error_reporting(-1);
				ini_set('display_errors', 1);
			break;

			case 'testing':
			case 'production':
				ini_set('display_errors', 0);
				if (version_compare(PHP_VERSION, '5.3', '>='))
				{
					error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
				}
				else
				{
					error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
				}
			break;

			default:
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'El medio ambiente de la aplicación no es correcto.';
				exit(1);
		}
	}
}