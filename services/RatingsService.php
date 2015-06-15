<?php

namespace Craft;

/**
 * Class RatingsService.
 */
class RatingsService extends BaseApplicationComponent
{
    /** @var string */
    private $_cookie;
    /** @var string */
    private $_cookieName;
    /** @var int */
    private $_cookieExpires;

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        $plugin = craft()->plugins->getPlugin('ratings');
        if (!$plugin) {
            throw new Exception('Couldn’t find the Ratings plugin!');
        }
        $this->_cookieName = substr(md5('rates'), -33);
        $this->_cookieExpires = strtotime('Jan. 1, 2099');
        $this->_loadCookie();
    }

    /**
     * Most popular item(s) in specified time period.
     *
     * @param string $startTime
     * @param string $endTime
     * @param int    $limit
     *
     * @return BaseElementModel[]
     */
    public function mostPopular($startTime, $endTime = null, $limit = 1)
    {
        $where = ':start < UNIX_TIMESTAMP(dateCreated) AND UNIX_TIMESTAMP(dateCreated) < :end';
        $pdo = array(
            ':start' => strtotime($startTime),
            ':end' => ($endTime ? strtotime($endTime) :  strtotime(time())),
        );
        $sql = craft()->db->createCommand();
        $sql
            ->select('elementId')
            ->from('ratings')
            ->where($where, $pdo)
            ->group('elementId')
            ->order('AVG(rating) DESC')
            ->limit($limit)
        ;
        $entries = array();
        foreach ($sql->queryAll() as $row) {
            $entries[] = craft()->elements->getElementById($row['elementId']);
        }
        if (!count($entries)) {
            return;
        } elseif (1 == $limit) {
            return $entries[0];
        } else {
            return $entries;
        }
    }

    /**
     * Average rating of this element.
     *
     * @param $elementId
     *
     * @return float|int
     */
    public function averageRating($elementId)
    {
        $ratingRecords = RatingsRecord::model()->findAllByAttributes(array(
            'elementId' => $elementId,
        ));

        if (empty($ratingRecords)) {
            return 0;
        }

        $allRatings = array();
        foreach ($ratingRecords as $r) {
            $record = $r->getAttributes();
            $allRatings[] = $record['rating'];
        }

        return array_sum($allRatings) / count($allRatings);
    }

    /**
     * My rating of this element.
     *
     * @param $elementId
     *
     * @return bool
     */
    public function myRating($elementId)
    {
        if ($this->_isInCookie($elementId)) {
            return $this->_cookie[$elementId];
        } else {
            return false;
        }
    }

    /**
     * Whether or not user has rated this element.
     *
     * @param $elementId
     *
     * @return bool
     */
    public function hasRated($elementId)
    {
        return $this->_isInCookie($elementId);
    }

    /**
     * Add a rating.
     *
     * @param $elementId
     * @param $rating
     *
     * @return mixed
     */
    public function addRating($elementId, $rating)
    {
        if (!$this->_isInCookie($elementId) && $rating != '') {
            $ratingRecord = new RatingsRecord();
            $attr = array(
                'elementId' => $elementId,
                'rating' => $rating,
            );
            $ratingRecord->setAttributes($attr, false);
            $this->_addToCookie($elementId, $rating);

            return $ratingRecord->save();
        }
    }

    /**
     * Save user rating data as cookie.
     *
     * @return bool
     */
    private function _saveCookie()
    {
        $cookieData = base64_encode(json_encode($this->_cookie));

        return setcookie($this->_cookieName, $cookieData, $this->_cookieExpires, '/');
    }

    /**
     * Get user rating data from cookie.
     *
     * @return bool
     */
    private function _loadCookie()
    {
        if (array_key_exists($this->_cookieName, $_COOKIE)) {
            $this->_cookie = $_COOKIE[$this->_cookieName];
            $this->_cookie = base64_decode($this->_cookie);
            $this->_cookie = preg_replace('/%.*$/', '', $this->_cookie);
            $this->_cookie = json_decode($this->_cookie, true);

            return (bool) $this->_cookie;
        } else {
            $this->_cookie = array();

            return $this->_saveCookie();
        }
    }

    /**
     * Check if rating exists in user data.
     *
     * @param $elementId
     *
     * @return bool
     */
    private function _isInCookie($elementId)
    {
        return array_key_exists($elementId, $this->_cookie);
    }

    /**
     * Add rating to user data.
     *
     * @param $elementId
     * @param $rating
     *
     * @return bool
     */
    private function _addToCookie($elementId, $rating)
    {
        $this->_cookie[$elementId] = $rating;
        $rating;

        return $this->_saveCookie();
    }
}
