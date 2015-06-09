<?php

namespace Craft;

/**
 * Class RatingsPlugin
 */
class RatingsPlugin extends BasePlugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return Craft::t('Ratings');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Bart van Gennep';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://www.itmundi.nl';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return true;
    }
}
