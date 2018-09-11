<?php

/**
 * @copyright  Copyright 2017 SplashLab
 */

namespace SplashLab\CorsRequests\Plugin;

use Magento\Framework\Webapi\Request;
use Magento\Framework\Exception\InputException;

/**
 * Class CorsRequestOptionsPlugin
 *
 * @package SplashLab\CorsRequests
 */
class CorsRequestOptionsPlugin
{

    /**
     * Triggers before original dispatch
     * Allow Options requests from jQuery AJAX
     *
     * @param Request $subject
     * @return void
     * @throws InputException
     */
    public function aroundGetHttpMethod(
        Request $subject
    ) {
        if (!$subject->isGet() && !$subject->isPost() && !$subject->isPut() && !$subject->isDelete() && !$subject->isOptions()) {
            throw new InputException(__('Request method is invalid.'));
        }
        return $subject->getMethod();
    }

}