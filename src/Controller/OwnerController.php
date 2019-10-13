<?php

namespace App\Controller;

use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OwnerController extends AbstractController
{
    /**
     * @Route("/owner", name="owner")
     */
    public function index()
    {
        $owners = $this->getDoctrine()->getRepository(Owner::class)->findAll();

        return $this->render('owner/index.html.twig', [
            'controller_name' => 'owners',
        ]);
    }
}
