<?php

namespace Wikibot\Api;

use DataValues\Deserializers\DataValueDeserializer;
use Wikibase\DataModel\DeserializerFactory;
use Wikibase\DataModel\Entity\BasicEntityIdParser;

class WikibotApi {

	public function getEntitySerializer() {
		return $this->getDeserializerFactory()->newEntityDeserializer();
	}

	private function getDeserializerFactory() {
		return new DeserializerFactory(
			new DataValueDeserializer( $this->getDataValueMap() ),
			new BasicEntityIdParser()
		);
	}

	private function getDataValueMap() {
		return array(
			'globecoordinate' => 'DataValues\GlobeCoordinateValue',
			'monolingualtext' => 'DataValues\MonolingualTextValue',
			'multilingualtext' => 'DataValues\MultilingualTextValue',
			'quantity' => 'DataValues\QuantityValue',
			'time' => 'DataValues\TimeValue',
			'wikibase-entityid' => 'Wikibase\DataModel\Entity\EntityIdValue',
			'string' => 'DataValues\StringValue'
		);
	}

	public static function getInstance() {
		return new self();
	}

}
