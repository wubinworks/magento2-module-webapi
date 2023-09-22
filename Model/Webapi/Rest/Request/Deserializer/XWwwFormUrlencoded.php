<?php
/**
 * application/x-www-form-urlencoded deserializer of REST request content.
 *
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wubinworks\Webapi\Model\Webapi\Rest\Request\Deserializer;

use Magento\Framework\Phrase;

class XWwwFormUrlencoded implements \Magento\Framework\Webapi\Rest\Request\DeserializerInterface
{
    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * @var \Magento\Framework\Webapi\Request
     */
    protected $request;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\State $appState
     * @param \Magento\Framework\Webapi\Request $request
     */
    public function __construct(
        \Magento\Framework\App\State $appState,
        \Magento\Framework\Webapi\Request $request
    ) {
        $this->appState = $appState;
        $this->request = $request;
    }

    /**
     * Parse Request body into array of params.
     *
     * @param string $encodedBody Posted content from request. Actually the input $encodedBody is impossible to be an empty string, see \Magento\Framework\Webapi\Rest\Request::getBodyParams
     * @return array
     * @throws \InvalidArgumentException masked in non-developer mode.
     * @throws \Magento\Framework\Webapi\Exception Exception message is showed to user, default http code 400(bad request).
     */
    public function deserialize($encodedBody)
    {
        if (!is_string($encodedBody)) {
            if ($this->appState->getMode() === \Magento\Framework\App\State::MODE_DEVELOPER) {
                throw new \Magento\Framework\Webapi\Exception(
                    new Phrase(
                        '$encodedBody has invalid data type "%s". String is expected.',
                        [gettype($encodedBody)]
                    )
                );
            } else {
                throw new \InvalidArgumentException(
                    sprintf('$encodedBody has invalid data type "%s". String is expected.', gettype($encodedBody))
                );
            }
        }

        if (!strlen($encodedBody)) {
            throw new \Magento\Framework\Webapi\Exception(
                new Phrase(
                    'POST body is empty.'
                )
            );
        }

        if ($this->request->getPostValue() === []) {
            throw new \Magento\Framework\Webapi\Exception(
                new Phrase(
                    'POST body is invalid.'
                )
            );
        }

        return $this->request->getPostValue();
    }
}
