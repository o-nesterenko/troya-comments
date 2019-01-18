<?php

namespace Troya\Comments\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{

    const TROYA_COMMENTS_TBL = 'troya_comments';


    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Create table 'troya_comments'
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable(self::TROYA_COMMENTS_TBL))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Reference ID'
            )
            ->addColumn(
                'parent_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => false],
                'Parent Comment ID'
            )
            ->addColumn(
                'child_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => false],
                'Children Comment ID'
            )
            ->addIndex(
                $setup->getIdxName(
                    self::TROYA_COMMENTS_TBL,
                    ['parent_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['parent_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX]
            )
            ->addForeignKey(
                $setup->getFkName(self::TROYA_COMMENTS_TBL, 'parent_id', 'review', 'review_id'),
                'parent_id',
                $setup->getTable('review'),
                'review_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment("Associated Comments Table");
        $setup->getConnection()->createTable($table);
    }
}