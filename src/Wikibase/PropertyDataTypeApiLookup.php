<?php

namespace Wikibot\Api\Wikibase;

use Wikibase\DataModel\Entity\PropertyDataTypeLookup;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\Store\EntityLookup;

class PropertyDataTypeApiLookup implements PropertyDataTypeLookup {

	public function __construct( EntityLookup $entityLookup ) {
		$this->entityLookup = $entityLookup;
	}

	public function getDataTypeIdForProperty( PropertyId $propertyId ) {
		$property = $this->entityLookup->getEntity( $propertyId );
		return $property->getDataTypeId();
	}

}
