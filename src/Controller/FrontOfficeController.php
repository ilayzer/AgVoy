<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Room;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FrontOfficeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function home()
    {
        return $this->render('front_office/home.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/regions", name="regions_index", methods={"GET"})
     * @param RegionRepository $regionRepository
     * @return Response
     */
    public function indexRegions(RegionRepository $regionRepository): Response
    {
        return $this->render('front_office/index_regions.html.twig', [
            'regions' => $regionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/regions/{id}", name="rooms_of_region", methods={"GET"})
     * @param Region $region
     * @return Response
     */
    public function indexRooms(Region $region): Response
    {
        return $this->render('front_office/index_rooms.html.twig', [
            'region' => $region,
        ]);
    }

    /**
     * @Route("/rooms/{id}", name="rooms_show", methods={"GET"})
     * @param Room $room
     * @return Response
     */
    public function showRooms(Room $room): Response
    {
        return $this->render('front_office/show_rooms.html.twig', [
            'room' => $room,
        ]);
    }


    /**
     * @Route("/rooms/{id}/bookmark", name="bookmark", methods={"GET"})
     * @param Room $room
     * @param Request $request
     * @return Response
     */
    public function bookmark(Room $room, Request $request): Response
    {
        $route = $request->get('route');
        $routeParams = $request->get('routeParams');
        if (!$route) {
            throw new BadRequestHttpException();
        }
        if (!$routeParams) {
            $routeParams = [];
        }

        $likes = $this->get('session')->get('likes');
        if (!$likes) {
            $likes = [];
        }

        // si l'identifiant n'est pas présent dans le tableau des likes, l'ajouter
        if (!in_array($room->getId(), $likes)) {
            $likes[] = $room->getId();
            $this->get('session')->getFlashBag()->add('message', "La chambre a été enregistrée dans vos favoris");
        } else // sinon, le retirer du tableau
        {
            $likes = array_diff($likes, array($room->getId()));
            $this->get('session')->getFlashBag()->add('message', "La chambre a été retirée de vos favoris");
        }

        $this->get('session')->set('likes', $likes);
        return $this->redirectToRoute($route, $routeParams);
    }


    /**
     * @Route("/favoris", name="favoris", methods={"GET"})
     * @return Response
     */
    public function favoris(): Response
    {
        $likes = $this->get('session')->get('likes');
        $rooms = array();
        foreach ($likes as $id) {
            $room = $this->getDoctrine()->getRepository(Room::class)->find($id);
            $rooms[] = $room;
        }

        return $this->render('front_office/favoris.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}