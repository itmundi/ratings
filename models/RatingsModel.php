<?php

namespace Craft;

/**
 * Class RatingsModel.
 */
class RatingsModel extends EntryModel
{
    /** @var string  */
    protected $elementType = 'Ratings';

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'count' => AttributeType::Number,
            'rating' => AttributeType::Number,
            'sectionId' => AttributeType::Number,
        ));
    }
}
