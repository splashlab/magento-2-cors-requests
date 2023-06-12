<?php
/**
 * @copyright  Copyright 2017 SplashLab
 */

declare(strict_types=1);

namespace Creatuity\CorsRequests\Plugin;

use Magento\Framework\Webapi\Request;
use Magento\Framework\Exception\InputException;

/**
 * Class CorsRequestOptionsPlugin
 *
 * @package Creatuity\CorsRequests
 */
class CorsRequestOptionsPlugin
{

    /**
     * Triggers before original dispatch
     * Allow Options requests from jQuery AJAX
     *
     * @param Request $subject
     * @return string
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
