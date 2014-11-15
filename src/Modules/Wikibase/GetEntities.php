<?php

namespace Wikibot\Api\Modules\Wikibase;

use Wikibase\DataModel\Entity\EntityId;
use WikiClient\MediaWiki\ApiClient;

class GetEntities {

	/**
	 * @var ApiClient
	 */
	private $client;

	/**
	 * @param ApiClient $client
	 */
	public function __construct( ApiClient $client ) {
		$this->client = $client;
	}

	/**
	 * @param EntityId $entityId
	 *
	 * @return array
	 */
	public function getByEntityId( EntityId $entityId ) {
		$params = array(
			'action' => 'wbgetentities',
			'ids' => $entityId->getSerialization()
		);

		$json = $this->request( $params );

		return $this->handleResponse( $json );
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
