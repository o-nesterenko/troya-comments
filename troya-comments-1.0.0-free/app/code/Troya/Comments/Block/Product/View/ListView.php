<?php

namespace Troya\Comments\Block\Product\View;

use Magento\Catalog\Api\ProductRepositoryInterface;
use \Troya\Comments\Model\CommentsFactory;

class ListView extends \Magento\Review\Block\Product\View\ListView
{

    /** @var \Troya\Comments\Model\CommentsFactory */
    protected $commentsRelations;

    /** @var array */
    public $relationsTree;

    public $relationCommentsCollection;

    public $filteredReviews;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        array $data = [],
        CommentsFactory $commentsRelations
    )
    {
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $collectionFactory,
            $data
        );

        $this->commentsRelations = $commentsRelations;

        $allIds = $this->getReviewsCollection()->getColumnValues('id');
        $this->relationCommentsCollection = $this->commentsRelations
            ->create()
            ->getCollection()
            ->addFieldToFilter('parent_id', array('in' => $allIds));
    }


    public function getRelationsTree()
    {
        if (!$this->relationsTree) {

            $this->relationsTree = [];

            if ($this->relationCommentsCollection->count()) {
                foreach ($this->relationCommentsCollection as $pair) {
                    if (!isset($this->relationsTree[$pair->getParentId()])) {
                        $this->relationsTree[$pair->getParentId()] = [$pair->getChildId()];
                    } else {
                        $this->relationsTree[$pair->getParentId()] += $pair->getChildId();
                    }
                }
            }
        }

        return $this->relationsTree;
    }


    public function getReviewItemsFiltered()
    {
        if (!$this->filteredReviews) {

            $this->filteredReviews['questions'] = [];
            $this->filteredReviews['answers'] = [];

            $childIds = $this->relationCommentsCollection->getColumnValues('child_id');
            foreach ($this->getReviewsCollection()->getItems() as $review) {
                if (in_array($review->getId(), $childIds)) {
                    $this->filteredReviews['answers'][$review->getId()] = $review;
                } else {
                    $this->filteredReviews['questions'] = $review;
                }
            }
        }

        return $this->filteredReviews;
    }


}