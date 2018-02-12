<?php
namespace Controller;
use Framework\BaseController;
use Framework\Request;
use Framework\Session;
use Model\Form\FeedbackForm;
use Model\Entity\Feedback;
class DefaultController extends BaseController
{
    const TEST = 123;

    /**
     * @return string
     */
    public function indexAction(Request $request)
    {
        // $obj = new \ReflectionClass($this);
        // $methods = $obj->getMethods();

        // dump(\PhpAcademy\HelloWorld\One::oneAction());

        // foreach ($methods as $method) {
        //     dump($method->getDocComment());
        // }


        return $this->render('index.html.twig', ['a' => '<b>1</b>']);
    }

    public function feedbackAction(Request $request)
    {
        $form = new FeedbackForm(
            $request->post('email'),  // $_POST['email']
            $request->post('message')
        );

        if ($request->isPost()) {
            if ($form->isValid()) {

                $feedback = new Feedback(
                    $form->email,
                    $form->message
                );

                $this->getRepository('Feedback')->save($feedback);

                Session::setFlash('Saved');

                $this
                    ->getRouter()
                    ->redirect('/feedback')
                ;
            }

            Session::setFlash('Form invalid');
        }

        return $this->render('feedback.html.twig', [
            'form' => $form
        ]);
    }

    public function apiFeedbackAction(Request $request)
    {
        header('content-type: application/json');
        $form = new FeedbackForm(
            $request->post('email'),  // $_POST['email']
            $request->post('message')
        );

        if ($request->isPost()) {
            if ($form->isValid()) {

                $feedback = new Feedback(
                    $form->email,
                    $form->message
                );

                try {
                    $this->getRepository('Feedback')->save($feedback);
                } catch (\Exception $e) {
                    http_response_code(500);

                    return json_encode([
                        'message' => 'Internal server error'
                    ]);
                }

                return json_encode([
                    'message' => 'Saved'
                ]);
            }

            http_response_code(400);

            return json_encode([
                'message' => 'Bad request'
            ]);
        }

        http_response_code(405);

        return json_encode([
            'message' => 'Method not allowed'
        ]);
    }

    public function zipAction(Request $request)
    {
        // todo: move to service

        $zip = new \ZipArchive();
        $filename = 'composer.zip';
        $filenamePath = ROOT . "../{$filename}";

        if ($zip->open($filenamePath, \ZipArchive::CREATE) !== true) {
            throw new \Exception("Failed to open file {$filename}");
        }

        $zip->addFile(ROOT . "../composer.json", "/composer.json");
        $zip->addFile(ROOT . "../composer.lock", "/composer.lock");
        $zip->close();

        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        readfile($filenamePath);
    }
}