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
        return $this->render("pages/index.html.twig", $this->getParameters());
    }

    protected function getParameters(): array {
        $params = [];
        $params['baseUrl'] = $this->container->get('router')->getContext()->getBaseUrl();

        return $params;
    }

}