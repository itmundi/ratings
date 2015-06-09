<?php

namespace Craft;

/**
 * Class FormBuilderElementType.
 */
class RatingsElementType extends BaseElementType
{
    /**
     * @return null|string
     */
    public function getRatings()
    {
        return Craft::t('FormBuilder');
    }

    /**
     * @param null $context
     *
     * @return array
     */
    public function getSources($context = null)
    {
        $sources = array(
            '*' => array(
                'label' => Craft::t('All ratings'),
            ),
        );

        return $sources;
    }

    /**
     * @param null $source
     *
     * @return array
     */
    public function defineTableAttributes($source = null)
    {
        return array(
            'id' => Craft::t('Title'),
            'count' => Craft::t('Count'),
            'rating' => Craft::t('Average rating'),
        );
    }

    /**
     * @return array
     */
    public function defineCriteriaAttributes()
    {
        return array(
            'count' => AttributeType::Number,
            'rating' => AttributeType::Number,
            'order' => array(AttributeType::String, 'default' => 'ratings.dateCreated desc'),
        );
    }

    /**
     * Modifies an element query targeting elements of this type.
     *
     * @param DbCommand            $query
     * @param ElementCriteriaModel $criteria
     *
     * @return mixed
     */
    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
        $query
            ->addSelect('entries.sectionId, ratings.elementId, count(rating) as count, round(avg(rating)) as rating')
            ->join('entries entries', 'entries.id = elements.id')
            ->join('ratings ratings', 'ratings.elementId = elements.id')
            ->group('ratings.elementId');
    }

    /**
     * Populates an element model based on a query result.
     *
     * @param array $row
     * @param bool  $normalize
     *
     * @return array
     */
    public function populateElementModel($row, $normalize = false)
    {
        return RatingsModel::populateModel($row);
    }
}
