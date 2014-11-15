<?php

namespace Wikibot\Api\Wikibase;

use Wikibase\DataModel\Entity\EntityId;
use Wikibase\Store\EntityLookup;
use Wikibase\Store\StorageException;
use Wikibot\Api\Modules\Wikibase\GetEntities;

class EntityApiLookup implements EntityLookup {

	/**
	 * @var GetEntities
	 */
	private $getEntities;

	public function __construct( GetEntities $getEntities ) {
		$this->getEntities = $getEntities;
	}

	/**
	 * @param EntityId $entityId
	 *
	 * @return Entity
	 */
	public function getEntity( EntityId $entityId ) {
		return $this->getEntities->getByEntityId( $entityId );
	}

	/**
	 * @param EntityId $entityId
	 *
	 * @return boolean
	 */
	public function hasEntity( EntityId $entityId ) {
		try {
			$this->getEntities->getByEntityId( $entityId );
			return true;
		} catch ( StorageException $ex ) {
			return false;
		}
	}

}
