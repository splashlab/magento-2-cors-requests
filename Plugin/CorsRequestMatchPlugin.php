<?php
/**
 * @copyright  Copyright 2017 SplashLab
 */

declare(strict_types=1);

namespace Creatuity\CorsRequests\Plugin;

use Magento\Framework\Controller\Router\Route\Factory;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Webapi\Controller\Rest\Router;
use Magento\Webapi\Controller\Rest\Router\Route;
use Magento\Webapi\Model\Rest\Config;

/**
 * Class CorsRequestMatchPlugin
 *
 * @package Creatuity\CorsRequests
 */
class CorsRequestMatchPlugin
{
    /**
     * Initialize dependencies.
     *
     * @param Request $request
     * @param Factory $routeFactory
     */
    public function __construct(
        private readonly Request $request,
        private readonly Factory $routeFactory
    ) {
    }

    /**
     * Generate the list of available REST routes. Current HTTP method is taken into account.
     *
     * @param Config $subject
     * @param $proceed
     * @param Request $request
     * @return Route
     * @throws Exception
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundMatch(
        Router $subject,
        callable $proceed,
        Request $request
    ): Route {
        try {
            $returnValue = $proceed($request);
        } catch (Exception $e) {
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
     * @return Route
     */
    protected function createRoute(): Route
    {
        /** @var $route Route */
        $route = $this->routeFactory->createRoute(
            'Magento\Webapi\Controller\Rest\Router\Route',
            '/V1/cors/check'
        );
        $route->setServiceClass('Creatuity\CorsRequests\Api\CorsCheckInterface')
            ->setServiceMethod('check')
            ->setSecure(false)
            ->setAclResources(['anonymous'])
            ->setParameters([]);

        return $route;
    }

}
