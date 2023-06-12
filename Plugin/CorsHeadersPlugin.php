<?php
/**
 * @copyright  Copyright 2017 SplashLab
 */

declare(strict_types=1);

namespace Creatuity\CorsRequests\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Webapi\Rest\Response;
use Magento\Store\Model\ScopeInterface;

/**
 * Class CorsHeadersPlugin
 *
 * @package Creatuity\CorsRequests
 */
class CorsHeadersPlugin
{
    private const XML_CORS_ORIGIN_URL = 'web/corsRequests/origin_url';
    private const XML_CORS_ALLOW_CREDENTIALS = 'web/corsRequests/allow_credentials';
    private const XML_CORS_ENABLE_AMP = 'web/corsRequests/enable_amp';
    private const XML_CORS_MAX_AGE = 'web/corsRequests/max_age';

    /**
     * Initialize dependencies.
     */
    public function __construct(
        private readonly Response $response,
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getOriginUrl(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_CORS_ORIGIN_URL,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return bool
     */
    protected function getAllowCredentials(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::XML_CORS_ALLOW_CREDENTIALS,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return bool
     */
    protected function getEnableAmp()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_CORS_ENABLE_AMP,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the Access-Control-Max-Age
     * @return int
     */
    protected function getMaxAge(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_CORS_MAX_AGE,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Triggers before original dispatch
     * This method triggers before original \Magento\Webapi\Controller\Rest::dispatch and set version
     * from request params to VersionManager instance
     * @param FrontControllerInterface $subject
     * @param RequestInterface $request
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(
        FrontControllerInterface $subject,
        RequestInterface $request
    ): void {
        if ($originUrl = $this->getOriginUrl()) {
            $this->response->setHeader('Access-Control-Allow-Origin', rtrim($originUrl,'/'), true);

            if ($this->getAllowCredentials()) {
                $this->response->setHeader('Access-Control-Allow-Credentials', 'true', true);
            }
            if ($this->getEnableAmp()) {
                $this->response->setHeader('AMP-Access-Control-Allow-Source-Origin', rtrim($originUrl,'/'), true);
            }
            if ($this->getMaxAge() > 0) {
                $this->response->setHeader('Access-Control-Max-Age', $this->getMaxAge(), true);
            }
        }
    }

}
