<?php

namespace Troya\Comments\Model;

class Comments extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'troya_comments_comment';

    protected $_cacheTag = 'troya_comments_comment';

    protected $_eventPrefix = 'troya_comments_comment';

    protected function _construct()
    {
        $this->_init('Troya\Comments\Model\ResourceModel\Comments');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}