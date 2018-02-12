<?php
namespace Controller;
use Framework\BaseController;
use Framework\Request;
use Framework\Session;
use Model\Form\FeedbackForm;
use Model\Entity\Feedback;
class TestController extends BaseController
{
    public function testAction(Request $request)
    {
        return json_encode(['a' => $request->get('one')]);
    }
}