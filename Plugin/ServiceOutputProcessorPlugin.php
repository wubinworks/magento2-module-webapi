<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wubinworks\Webapi\Plugin;

class ServiceOutputProcessorPlugin
{
    /**
     * Modifies the JSON output behavior when $data['type'] === 'simple_array'.
     * How to use? How will the output behave?
     * @see https://github.com/wubinworks/magento2-module-webapi Features and Usage Section
     *
     * @param \Magento\Framework\Webapi\ServiceOutputProcessor $subject
     * @param array|object $result
     * @param array $data
     * @param string $type
     * @return array|object
     */
    public function afterConvertValue(
        \Magento\Framework\Webapi\ServiceOutputProcessor $subject,
        $result,
        $data,
        $type
    ) {
        if(is_array($data) && array_key_exists('type', $data) && $data['type'] === 'simple_array') {
            unset($data['type']);
            return $data;
        }

        return $result;
    }
}
