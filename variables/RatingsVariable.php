<?php

namespace Craft;

/**
 * Class RatingsVariable.
 */
class RatingsVariable
{
    /**
     * Show stars of specified element.
     *
     * @param bool $elementId
     *
     * @return mixed
     */
    public function of($elementId = false)
    {
        return craft()->ratings->myRating($elementId);
    }

    /**
     * Display average total value of element.
     *
     * @param $elementId
     *
     * @return mixed
     */
    public function avg($elementId)
    {
        return craft()->ratings->averageRating($elementId);
    }

    /**
     * Whether or not the element has been rated.
     *
     * @param $elementId
     *
     * @return bool
     */
    public function rated($elementId)
    {
        return craft()->ratings->hasRated($elementId);
    }

    /**
     * @param string $startTime
     * @param string $endTime
     * @param int    $limit
     *
     * @return BaseElementModel[]
     */
    public function mostPopular($startTime, $endTime = null, $limit = 1)
    {
        return craft()->ratings->mostPopular($startTime, $endTime, $limit);
    }
}
