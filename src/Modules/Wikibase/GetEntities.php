<?php

namespace Wikibot\Api\Modules\Wikibase;

use Deserializers\Deserializer;
use Wikibase\DataModel\Entity\EntityId;
use Wikibase\Store\StorageException;
use WikiClient\MediaWiki\ApiClient;

class GetEntities {

	/**
	 * @var ApiClient
	 */
	private $client;

	/**
	 * @var Deserializer
	 */
	private $deserializer;

	/**
	 * @param ApiClient $client
	 * @param Deserializer $deserializer
	 */
	public function __construct( ApiClient $client, Deserializer $deserializer ) {
		$this->client = $client;
		$this->deserializer = $deserializer;
	}

	/**
	 * @param EntityId $entityId
	 *
	 * @return Entity
	 */
	public function getByEntityId( EntityId $entityId ) {
		$prefixedId = $entityId->getSerialization();

		$params = array(
			'action' => 'wbgetentities',
			'ids' => $prefixedId
		);

		$json = $this->request( $params );

		$data = $this->handleResponse( $json );

		return $this->extractEntityFromResponse( $prefixedId, $data );
	}

	private function extractEntityFromResponse( $prefixedId, array $data ) {
		$keys = array_keys( $data['entities'] );

		if ( isset( $keys[0] ) ) {
			$entityId = $keys[0];

			if ( $entityId !== $prefixedId ) {
				throw new StorageException( 'Result mismatches requested id' );
			}

			$serialization = $data['entities'][$entityId];

			if ( $this->deserializer->isDeserializerFor( $serialization ) ) {
				return $this->deserializer->deserialize( $serialization );
			}
		}

		throw new StorageException( 'Entity not found: ' . $prefixedId );
	}

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	private function request( array $params ) {
		return $this->client->get( $params );
	}

	/**
	 * @param string $json
	 *
	 * @return array
	 */
	private function handleResponse( $json ) {
		return json_decode( $json, true );
	}

}
