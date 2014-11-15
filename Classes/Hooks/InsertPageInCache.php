<?php
namespace Opendo\NginxMemcached\Hooks;
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Philipp Bergsmann <p.bergsmann@opendo.at>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;


/**
 * $DESCRIPTION$
 *
 * @author	Philipp Bergsmann <p.bergsmann@opendo.at>
 * @package $PACKAGE$
 * @subpackage $SUBPACKAGE$
 */
class InsertPageInCache {
	public function insertPageIncache(TypoScriptFrontendController $pObj, $timeOutTime) {
		/** @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache */
		$cache = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')
				->getCache('cache_nginx_memcached');

		$cacheIdentifier = GeneralUtility::getIndpEnv('REQUEST_URI');
		$cacheIdentifier = (strstr($cacheIdentifier, '?')) ? $cacheIdentifier : $cacheIdentifier . '?';

		$pageCacheTags = array();

		$cacheData = array(
			'page_id' => $pObj->id,
			'content' => $pObj->content,
			'temp_content' => $pObj->tempContent,
			'cache_data' => $pObj->config,
			'expires' => $timeOutTime,
			'tstamp' => $GLOBALS['EXEC_TIME']
		);

		$pageCacheTags[] = 'pageId_' . $cacheData['page_id'];
		if ($pObj->page_cache_reg1) {
			$reg1 = (int)$pObj->page_cache_reg1;
			$cacheData['reg1'] = $reg1;
			$pageCacheTags[] = 'reg1_' . $reg1;
		}
		if (!empty($pObj->page['cache_tags'])) {
			$tags = GeneralUtility::trimExplode(',', $pObj->page['cache_tags'], TRUE);
			$pageCacheTags = array_merge($pageCacheTags, $tags);
		}

		$cache->set($cacheIdentifier, $pObj->content, $pageCacheTags, $cacheData['expires'] - $GLOBALS['EXEC_TIME']);
	}
}
?>