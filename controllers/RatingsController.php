<?php

namespace Craft;

/**
 * Class RatingsController.
 */
class RatingsController extends BaseController
{
    protected $allowAnonymous = true;

    /**
     * Rate specified element.
     *
     * @throws HttpException
     */
    public function actionRate()
    {
        $this->requireAjaxRequest();
        $this->requirePostRequest();

        $elementId = craft()->request->getPost('id');
        $rating = craft()->request->getPost('rating');
        $response = craft()->ratings->addRating($elementId, $rating);
        $this->returnJson($response);
    }
}
