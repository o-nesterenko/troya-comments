<?php

namespace Troya\Comments\Model\ResourceModel\Comments;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected $_eventPrefix = 'troya_comments_comment_collection';

    protected $_eventObject = 'comments_collection';


    protected function _construct()
    {
        $this->_init('Troya\Comments\Model\Comments', 'Troya\Comments\Model\ResourceModel\Comments');
    }

}