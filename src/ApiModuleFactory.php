<?php

namespace Wikibot\Api;

use Wikibot\Api\Modules\CategoryMembers;
use Wikibot\Api\Modules\Wikibase\GetEntities;
use WikiClient\MediaWiki\ApiClientFactory;

class ApiModuleFactory {

	/**
	 * @var ApiClientFactory
	 */
	private $clientFactory;

	/**
	 * @param ApiClientFactory $clientFactory
	 */
	public function __construct( ApiClientFactory $clientFactory ) {
		$this->clientFactory = $clientFactory;
	}

	public function newModule( $siteId, $moduleName ) {
		$client = $this->clientFactory->getClient( $siteId );

		switch ( $moduleName ) {
			case 'categorymembers':
				return new CategoryMembers( $client );
			case 'wbgetentities':
				return new GetEntities( $client );
			default:
				throw new \InvalidArgumentException( "$moduleName module not found." );
		}
	}

}
