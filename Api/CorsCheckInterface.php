<?php
/**
 * @copyright  Copyright 2017 SplashLab
 */

namespace Creatuity\CorsRequests\Api;

/**
 * Interface CorsCheckInterface
 * @api
 * @package Creatuity\CorsRequests\Api
 */
interface CorsCheckInterface
{
    /**
     * Return empty body response
     *
     * @return string
     */
    public function check(): string;

}
