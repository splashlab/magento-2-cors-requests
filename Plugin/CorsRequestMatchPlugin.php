<?php

/**
 * @copyright  Copyright 2017 SplashLab
 */

namespace SplashLab\CorsRequests\Plugin;

use Magento\Framework\Webapi\Rest\Request;
use Magento\Webapi\Controller\Rest\Router;

/**
 * Class CorsRequestMatchPlugin
 *
 * @package SplashLab\CorsRequests
 */
class CorsRequestMatchPlugin
{

    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Router\Route\Factory
     */
    protected $routeFactory;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @param \Magento\Framework\Controller\Router\Route\Factory $routeFactory
     */
    public function __construct(
        \Magento\Framework\Webapi\Rest\Request $request,
        \Magento\Framework\Controller\Router\Route\Factory $routeFactory
    ) {
        $this->request = $request;
        $this->routeFactory = $routeFactory;
    }

    /**
     * Generate the list of available REST routes. Current HTTP method is taken into account.
     *
     * @param \Magento\Webapi\Model\Rest\Config $subject
     * @param $proceed
     * @param Request $request
     * @return \Magento\Webapi\Controller\Rest\Router\Route
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function aroundMatch(
        Router $subject,
        callable $proceed,
        Request $request
    )
    {
        try {
            $returnValue = $proceed($request);
        } catch (\Magento\Framework\Webapi\Exception $e) {
            $requestHttpMethod = $this->request->getHttpMethod();
            if ($requestHttpMethod == 'OPTIONS') {
                return $this->createRoute();
            } else {
                throw $e;
            }
        }
        return $returnValue;
    }

    /**
     * Create route object to the placeholder CORS route.
     *
     * @return \Magento\Webapi\Controller\Rest\Router\Route
     */
    protected function createRoute()
    {
        /** @var $route \Magento\Webapi\Controller\Rest\Router\Route */
        $route = $this->routeFactory->createRoute(
            'Magento\Webapi\Controller\Rest\Router\Route',
            '/V1/cors/check'
        );

        $route->setServiceClass('SplashLab\CorsRequests\Api\CorsCheckInterface')
            ->setServiceMethod('check')
            ->setSecure(false)
            ->setAclResources(['anonymous'])
            ->setParameters([]);

        return $route;
    }

}