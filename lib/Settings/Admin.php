<?php
namespace OCA\Osm\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\IConfig;
use OCP\Settings\ISettings;

use OCA\Osm\AppInfo\Application;

class Admin implements ISettings {

	private IConfig $config;
	private IInitialState $initialStateService;
	private ?string $userId;

	public function __construct(IConfig       $config,
								IInitialState $initialStateService,
								?string       $userId) {
		$this->config = $config;
		$this->initialStateService = $initialStateService;
		$this->userId = $userId;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm(): TemplateResponse {
		$searchLocationEnabled = $this->config->getAppValue(Application::APP_ID, 'search_location_enabled', Application::DEFAULT_SEARCH_LOCATION_ENABLED_VALUE) === '1';
		$maptilerApiKey = $this->config->getAppValue(Application::APP_ID, 'maptiler_api_key');
		$mapboxApiKey = $this->config->getAppValue(Application::APP_ID, 'mapbox_api_key');

		$state = [
			'search_location_enabled' => $searchLocationEnabled,
			'maptiler_api_key' => $maptilerApiKey,
			'mapbox_api_key' => $mapboxApiKey,
		];
		$this->initialStateService->provideInitialState('admin-config', $state);
		return new TemplateResponse(Application::APP_ID, 'adminSettings');
	}

	public function getSection(): string {
		return 'connected-accounts';
	}

	public function getPriority(): int {
		return 10;
	}
}
