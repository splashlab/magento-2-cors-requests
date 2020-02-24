<?php

/**
 * @copyright  Copyright 2017 SplashLab
 */

namespace SplashLab\CorsRequests\Plugin;

use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class CorsHeadersPlugin
 *
 * @package SplashLab\CorsRequests
 */
class CorsHeadersPlugin
{

    /**
     * @var \Magento\Framework\Webapi\Rest\Response
     */
    private $response;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Webapi\Rest\Response $response
     * @param \Magento\Framework\App\Config\ScopeConfigInterface scopeConfig
     */
    public function __construct(
        \Magento\Framework\Webapi\Rest\Response $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getOriginUrl()
    {
        return $this->scopeConfig->getValue('web/corsRequests/origin_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getAllowCredentials()
    {
        return (bool) $this->scopeConfig->getValue('web/corsRequests/allow_credentials',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getEnableAmp()
    {
        return (bool) $this->scopeConfig->getValue('web/corsRequests/enable_amp',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the Access-Control-Max-Age
     * @return string
     */
    protected function getMaxAge()
    {
        return (int) $this->scopeConfig->getValue('web/corsRequests/max_age',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
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
    ) {
        if ($originUrl = $this->getOriginUrl()) {
            $this->response->setHeader('Access-Control-Allow-Origin', rtrim($originUrl,"/"), true);
            if ($this->getAllowCredentials()) {
                $this->response->setHeader('Access-Control-Allow-Credentials', 'true', true);
            }
            if ($this->getEnableAmp()) {
                $this->response->setHeader('AMP-Access-Control-Allow-Source-Origin', rtrim($originUrl,"/"), true);
            }
            if ((int)$this->getMaxAge() > 0) {
                $this->response->setHeader('Access-Control-Max-Age', $this->getMaxAge(), true);
            }
        }
    }

}