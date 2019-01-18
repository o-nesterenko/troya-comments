<?php

namespace Troya\Comments\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const IS_ENABLED_XPATH = 'comments/general/enable';

    /**
     * @var bool
     */
    public $isEnabled;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */

    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {

        parent::__construct($context);

        $this->isEnabled = $this->scopeConfig()
            ->isSetFlag(self::IS_ENABLED_XPATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

    }

}
