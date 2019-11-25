<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Comment;
use App\Entity\Room;
use App\Entity\Unavailability;
use App\Form\RoomType;
use App\Form\UnavailabilityType;
use App\Repository\BookingRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/owner")
 */
class OwnerOfficeController extends AbstractController
{
    /**
     * @Route("/", name="owner")
     */
    public function home()
    {
        return $this->render('owner_office/home.html.twig', [
            'controller_name' => 'OwnerOfficeController',
        ]);
    }


    /**
     * @Route("/room", name="room_owner_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $rooms = $this->getUser()->getOwner()->getRooms();

        return $this->render('owner_office/room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * @Route("/room/new", name="room_owner_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_owner_index');
        }

        return $this->render('owner_office/room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/room/{id}", name="room_owner_show", methods={"GET"})
     * @param Room $room
     * @return Response
     */
    public function show(Room $room): Response
    {
        if ($room->getOwner()->getId() !== $this->getUser()->getOwner()->getId()) {
            throw new AccessDeniedHttpException('Cette chambre ne vous appartient pas !');
        }

        return $this->render('owner_office/room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("room_/{id}/edit", name="room_owner_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Room $room
     * @return Response
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_owner_index');
        }

        return $this->render('owner_office/room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("room/{id}", name="room_owner_delete", methods={"DELETE"})
     * @param Request $request
     * @param Room $room
     * @return Response
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_owner_index');
    }


    /**
     * @Route("/comments", name="comment_owner_index", methods={"GET"})
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index2()
    {
        return $this->render('owner_office/index_comments.html.twig');
    }

    /**
     * @route("/comments/{id}/accept", name="accept_comment", methods={"GET"})
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function accept_comment(Comment $comment)
    {
        $comment->setAccepted(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('comment_owner_index');
    }

    /**
     * @route("/comments/{id}/delete", name="delete_comment", methods={"GET"})
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function delete_comment(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('comment_owner_index');
    }


    /**
     * @Route("/bookings", name="booking_owner_index", methods={"GET"})
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    public function index3()
    {
        return $this->render('owner_office/index_booking.html.twig');
    }

    /**
     * @route("/bookings/{id}/accept", name="accept_booking", methods={"GET"})
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function accept_booking(Booking $booking)
    {
        $booking->setConfirmed(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($booking);
        $em->flush();

        return $this->redirectToRoute('booking_owner_index');
    }

    /**
     * @route("/bookings/{id}/delete", name="delete_booking", methods={"GET"})
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function delete_booking(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($booking);
        $em->flush();

        return $this->redirectToRoute('booking_owner_index');
    }

    /**
     * @Route("/unavailability/new", name="create_unavailability", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function addUnavailability(Request $request)
    {
        $unavailability = new Unavailability();

        $form = $this->createForm(UnavailabilityType::class, $unavailability, [
            'ownersRooms' => $this->getUser()->getOwner()->getRooms(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unavailability);
            $em->flush();

            return $this->redirectToRoute('owner');
        }

        return $this->render('owner_office/unavailability_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
