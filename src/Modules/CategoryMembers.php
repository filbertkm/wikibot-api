<?php

namespace Wikibot\Api\Modules;

use Wikibase\DataModel\SiteLink;
use WikiClient\MediaWiki\ApiClient;

class CategoryMembers {

	/**
	 * @var ApiClient
	 */
	private $client;

	/**
	 * @var string|null
	 */
	private $continue = null;

	/**
	 * @param ApiClient $client
	 */
	public function __construct( ApiClient $client ) {
		$this->client = $client;
	}

	/**
	 * @param string $cat
	 */
	public function members( $cat, $limit = 100 ) {
		$params = $this->buildParams( $cat, $limit );
		$json = $this->request( $params );

		return $this->handleResponse( $json );
	}

	/**
	 * @param string $cat
	 * @param int $limit
	 *
	 * @return array
	 */
	private function buildParams( $cat, $limit ) {
		$params = array(
			'action' => 'query',
			'list' => 'categorymembers',
			'cmlimit' => $limit,
			'cmnamespace' => 0,
			'cmprop' => 'title',
			'cmtitle' => "Category:$cat"
		);

		if ( $this->continue !== null ) {
			$params['cmcontinue'] = $this->continue;
		}

		return $params;
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
		$data = json_decode( $json, true );
		$this->setContinue( $data );

		return $data;
	}

	/**
	 * @param array $data
	 */
	private function setContinue( array $data ) {
		if ( isset( $data['query-continue'] ) ) {
			$this->continue = $data['query-continue']['categorymembers']['cmcontinue'];
		}
	}

	/**
	 * @return string|null
	 */
	public function getContinue() {
		return $this->continue;
	}

}
