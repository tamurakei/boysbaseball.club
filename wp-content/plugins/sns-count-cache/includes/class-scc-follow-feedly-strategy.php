<?php
/*
class-scc-follow-feedly-strategy.php

Description: This class is abstract class of a data crawler
Author: Daisuke Maruyama
Author URI: http://marubon.info/
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

/*
Copyright (C) 2014 - 2016 Daisuke Maruyama

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class SCC_Follow_Feedly_Strategy extends SCC_Crawl_Strategy {

	/**
	 * SNS base url
	 */
	const DEF_BASE_URL = 'http://cloud.feedly.com/v3/feeds/feed%2F';

	/**
	 * Class constarctor
	 * Hook onto all of the actions and filters needed by the plugin.
	 *
	 */
	protected function __construct() {
		SCC_Common_Util::log('[' . __METHOD__ . '] (line='. __LINE__ . ')');

		$this->method = 'GET';
	}

	/**
	 * Initialization
	 *
	 * @since 0.9.0
	 */
	public function initialize( $options = array() ) {
		SCC_Common_Util::log( '[' . __METHOD__ . '] (line='. __LINE__ . ')' );

		if ( isset( $options['url'] ) ) $this->url = $options['url'];
		if ( isset( $options['method'] ) ) $this->method = $options['method'];
		if ( isset( $options['parameters'] ) ) $this->parameters = $options['parameters'];
	}

	/**
	 * Build header
	 *
	 * @since 0.9.0
	 */
	public function build_header() {
		SCC_Common_Util::log( '[' . __METHOD__ . '] (line='. __LINE__ . ')' );
		return null;
	}

	/**
	 * Build query url
	 *
	 * @since 0.9.0
	 */
	public function build_query_url() {
		SCC_Common_Util::log( '[' . __METHOD__ . '] (line='. __LINE__ . ')' );

		$url = self::DEF_BASE_URL . rawurlencode( $this->query_parameters['url'] );

		return $url;
	}

	/**
	 * Extract count
	 *
	 * @since 0.9.0
	 */
	public function extract_count( $content ) {
		SCC_Common_Util::log( '[' . __METHOD__ . '] (line='. __LINE__ . ')' );

		$count = (int) -1;

		if ( isset( $content['data'] ) && empty( $content['error'] ) ) {
			$json = json_decode( $content['data'], true );

			if ( isset( $json['subscribers'] ) && is_numeric( $json['subscribers'] ) ) {
				$count = (int) $json['subscribers'];
			} else {
				$count = (int) -1;
			}
		} else {
			$count = (int) -1;
		}

		return $count;
	}

	/**
	 * Check if required paramters are included or not.
	 *
	 * @since 0.9.0
	 */
	public function check_configuration() {
		SCC_Common_Util::log( '[' . __METHOD__ . '] (line='. __LINE__ . ')' );

		if ( isset( $this->query_parameters['url'] ) && $this->query_parameters['url'] ) {
			return true;
		} else {
			return false;
		}
	}

}
