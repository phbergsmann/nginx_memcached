<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['insertPageIncache'][] = 'Opendo\NginxMemcached\Hooks\InsertPageInCache';

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_nginx_memcached'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_nginx_memcached'] = array(
		'backend' => 'Opendo\\NginxMemcached\\Cache\\Backend\\MemcachedBackend',
		'options' => array(
			'servers' => array(
				'127.0.0.1',
			),
		),
		'groups' => array('pages', 'all'),
	);
}

if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_nginx_memcached']['frontend'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_nginx_memcached']['frontend'] = 'Opendo\NginxMemcached\Cache\Frontend\VariableFrontend';
}

?>