<?php
/**
 * @copyright  Copyright 2017 SplashLab
 */

declare(strict_types=1);

namespace Creatuity\CorsRequests\Model;

use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Webapi\Rest\Response;
use Creatuity\CorsRequests\Api\CorsCheckInterface;

/**
 * Class CorsCheck
 *
 * @package Creatuity\CorsRequests\Model
 */
class CorsCheck implements CorsCheckInterface
{
    /**
     * Initialize dependencies.
     */
    public function __construct(
        private readonly Response $response,
        private readonly Request $request
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function check(): string
    {
        // respond to OPTIONS request with appropriate headers
        $this->response->setHeader('Access-Control-Allow-Methods', $this->request->getHeader('Access-Control-Request-Method'), true);
        $this->response->setHeader('Access-Control-Allow-Headers', $this->request->getHeader('Access-Control-Request-Headers'), true);
        return '';
    }

}
