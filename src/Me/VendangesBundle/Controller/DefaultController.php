<?php

namespace Me\VendangesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MeVendangesBundle:Default:index.html.twig');
    }
}
