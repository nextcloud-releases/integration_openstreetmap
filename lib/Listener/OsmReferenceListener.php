<?php
/**
 * @copyright Copyright (c) 2023 Julien Veyssier <eneiluj@posteo.net>
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\Osm\Listener;

use OCA\Osm\AppInfo\Application;
use OCP\AppFramework\Services\IInitialState;
use OCP\Collaboration\Reference\RenderReferenceEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\Util;

class OsmReferenceListener implements IEventListener {

	private IConfig $config;
	private IInitialState $initialState;

	public function __construct(IConfig       $config,
								IInitialState $initialState) {
		$this->config = $config;
		$this->initialState = $initialState;
	}

	public function handle(Event $event): void {
		if (!$event instanceof RenderReferenceEvent) {
			return;
		}

		$maptilerApiKey = $this->config->getAppValue(Application::APP_ID, 'maptiler_api_key', Application::DEFAULT_MAPTILER_API_KEY) ?: Application::DEFAULT_MAPTILER_API_KEY;
		$mapboxApiKey = $this->config->getAppValue(Application::APP_ID, 'mapbox_api_key', Application::DEFAULT_MAPBOX_API_KEY) ?: Application::DEFAULT_MAPBOX_API_KEY;
		$userConfig = [
			'maptiler_api_key' => $maptilerApiKey,
			'mapbox_api_key' => $mapboxApiKey,
		];
		$this->initialState->provideInitialState('api-keys', $userConfig);

		Util::addScript(Application::APP_ID, Application::APP_ID . '-referenceLocation');
	}
}
