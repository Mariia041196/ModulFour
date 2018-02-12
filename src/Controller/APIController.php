<?php
namespace Controller;
use Framework\BaseController;
use Framework\Request;
class APIController extends BaseController
{
    public function indexAction(Request $request)
    {
        header('Content-type: application/json');
        return json_encode($_POST);
    }

    public function firstAction(Request $request)
    {
        $a = $request->get('a');
        $a *= 2;
        header('Content-type: application/json');

        return json_encode(['a' => $a]);
    }

    public function secondAction(Request $request)
    {
        $a = $request->post('a');
        $a *= 5;
        header('Content-type: application/json');

        return json_encode(['a' => $a]);
    }
}