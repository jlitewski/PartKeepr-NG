<?php
namespace App\Controller\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This is the controller for the index page of PartKeepr-NG
 * 
 * @package App\Controller\Pages
 */
class IndexPage extends AbstractController {

    /**
     * @Route("/")
     */
    public function renderPage(): Response {
        return $this->render("base.html.twig");
    }

}