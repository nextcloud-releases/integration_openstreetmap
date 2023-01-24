<?php
/**
 * Nextcloud - OpenStreetMap
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 * @copyright Julien Veyssier 2023
 */

namespace OCA\Osm\Controller;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataDownloadResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\RedirectResponse;
use OCP\AppFramework\OCSController;
use OCP\IRequest;

use OCA\Osm\Service\OsmAPIService;
use OCP\IURLGenerator;

class OsmAPIController extends OCSController {

	private OsmAPIService $osmAPIService;
	private IURLGenerator $urlGenerator;
	private ?string $userId;

	public function __construct(string          $appName,
								IRequest        $request,
								OsmAPIService   $osmAPIService,
								IURLGenerator   $urlGenerator,
								?string         $userId) {
		parent::__construct($appName, $request);
		$this->osmAPIService = $osmAPIService;
		$this->urlGenerator = $urlGenerator;
		$this->userId = $userId;
	}
}
