<?php

namespace Craft;

/**
 * Class RatingRecord.
 */
class RatingsRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'ratings';
    }

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'rating' => array(
                AttributeType::Number,
                'column' => ColumnType::TinyInt,
                'length' => 1,
            ),
        );
    }

    /**
     * @return array
     */
    public function defineRelations()
    {
        return array(
            'element' => array(static::BELONGS_TO, 'ElementRecord', 'required' => true, 'onDelete' => static::CASCADE),
        );
    }
}
