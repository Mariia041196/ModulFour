<?php
namespace Controller;
use Framework\BaseController;
use Framework\Request;
use Framework\Session;
use Model\Form\FeedbackForm;
use Model\Entity\Feedback;
class CartController extends BaseController
{
    public function indexAction()
    {
        var_dump($this->container->get('cart_service')->getCartItems());
    }

    public function addAction(Request $request)
    {
        $id = $request->get('id');

        // add to cart
        $this->container->get('cart_service')->addItem($id);
        $this->getRouter()->redirect('/books');
    }

    public function removeItemAction()
    {

    }

    public function clearAction()
    {

    }
}