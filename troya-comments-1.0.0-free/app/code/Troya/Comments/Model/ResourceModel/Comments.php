<?php

namespace Troya\Comments\Model\ResourceModel;

class Comments extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(\Troya\Comments\Setup\InstallSchema::TROYA_COMMENTS_TBL, 'id');
    }

}