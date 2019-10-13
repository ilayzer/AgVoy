<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/public_room_show", name="public_room_show")
     */
    public function index()
    {
        $rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * @Route("/room_index", name="room_index")
     */
    public function index2()
    {
        $rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * @Route("/room_show/{id}", name="room_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);

        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/room_edit/{id}", name="room_edit")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);

        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $room = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_show', ['id' => $room->getId()]);
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/room_new", name="room_new")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $room = new Room();

        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $room = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_show', ['id' => $room->getId()]);
        }

        return $this->render('room/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
