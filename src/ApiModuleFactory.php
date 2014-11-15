<?php

namespace Wikibot\Api;

use Wikibot\Api\Modules\CategoryMembers;
use Wikibot\Api\Modules\Wikibase\GetEntities;
use WikiClient\MediaWiki\ApiClient;
use WikiClient\MediaWiki\User;
use WikiClient\MediaWiki\WikiFactory;

class ApiModuleFactory {

	/**
	 * @var array
	 */
	private $wikis;

	public function __construct( array $wikis ) {
		$this->wikis = $wikis;
	}

	public function newModule( $siteId, $moduleName ) {
		$client = $this->newApiClient( $siteId );

		switch ( $moduleName ) {
			case 'categorymembers':
				return new CategoryMembers( $client );
			case 'wbgetentities':
				return new GetEntities( $client );
			default:
				throw new \InvalidArgumentException( "$moduleName module not found." );
		}
	}

	private function newApiClient( $siteId ) {
		$wikiFactory = new WikiFactory( $this->wikis );
		$wiki = $wikiFactory->newWiki( $siteId );

		$userInfo = $this->wikis[$siteId]['user'];
		$user = new User(
			$userInfo['username'],
			$userInfo['password'],
			$this->wikis[$siteId]
		);

		return new ApiClient( $wiki, $user );
	}

}
