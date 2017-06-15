<?php

/**
 * @copyright  Copyright 2017 SplashLab
 */

namespace SplashLab\CorsRequests\Api;

/**
 * Interface CorsCheckInterface
 * @api
 * @package SplashLab\CorsRequests\Api
 */
interface CorsCheckInterface
{

    /**
     * Return empty body response
     *
     * @return string
     */
    public function check();

}