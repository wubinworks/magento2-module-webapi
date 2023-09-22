<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wubinworks\Webapi\Plugin;

class WebapiRestRequestPlugin
{
    /**
     * Conditionally modifies Content-Type of request.
     *
     * @param \Magento\Framework\Webapi\Rest\Request $subject
     * @param string $result
     * @return string
     */
    public function afterGetContentType(
        \Magento\Framework\Webapi\Rest\Request $subject,
        $result
    ) {
        /** Check if `Use-Deprecated-Content-Type: 1` header exists */
        if($result === 'application/x-www-form-urlencoded'
            && $subject->getHeader('Use-Deprecated-Content-Type') === '1'
        ) {
            /** @see webapi_rest/di.xml in this module */
            return 'application/wubinworks-x-www-form-urlencoded';
        }
        return $result;
    }
}
