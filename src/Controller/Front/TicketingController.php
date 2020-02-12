<?php

namespace App\Controller\Front;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Form\TicketsType;
use App\Services\CodeNumberGenerator;
use App\Services\Mailing;
use App\Services\PriceCalculator;
use App\Services\StripePayment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;


class TicketingController
{

    public function index(Environment $twig)
    {
        return new Response($twig->render('base.html.twig'));
    }

    public function booking(Environment $twig, FormFactoryInterface $formFactory, RouterInterface $router, Request $request): Response
    {
        $session = $request->getSession();
        if($session->has('booking')){
            $currentBooking = $session->get('booking');
        } else {
            $currentBooking = new Booking();
        }

        $form = $formFactory->createBuilder(BookingType::class, $currentBooking)->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $session->set('booking', $currentBooking);

            $url = $router->generate('booking_register');
            return new RedirectResponse($url);
        }

        return new Response($twig->render('Frontend/Ticketing/booking.html.twig', array(
            'form' => $form->createView()
        )));

    }

    public function register(Environment $twig, FormFactoryInterface $formFactory,RouterInterface $router, Request $request,ValidatorInterface $validator,FlashBagInterface $flashBag, PriceCalculator $priceCalculator, CodeNumberGenerator $codeGenerator): Response
    {
        $session = $request->getSession();

        if($session->has('booking')){
            $currentBooking = $session->get('booking');
            $tickets = $currentBooking->getTickets();
            $ticketQuantity = $currentBooking->getTicketQuantity();

            // Convert to an array for condition
            $ticketsToArray = (array)$tickets;
            // If request come from Checkout for editing, remove session tickets
            if (!empty(array_filter($ticketsToArray) )) {
                foreach ($tickets as $ticket){
                    $currentBooking->removeTicket($ticket);
                }
            }
        }



        $form = $formFactory->createBuilder(TicketsType::class, $currentBooking)->getForm();
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $bookingAmount = 0;
                foreach ($tickets as $ticket) {
                    $errors = $validator->validate($ticket);
                    if (count($errors) > 0) {
                        $errorString = (string)$errors;
                        $flashBag->add('info', $errorString);

                        $url = $router->generate('booking_register');
                        return new RedirectResponse($url);
                    }

                    $ticketPrice = $priceCalculator->calculating($ticket);
                    $bookingAmount += $ticketPrice;
                }

                $currentBooking->setAmount($bookingAmount);
                $currentBooking->setCommandNumber($codeGenerator->sendCodeCommand());

                $url = $router->generate('booking_checkout');
                return new RedirectResponse($url);
            }


        return new Response($twig->render('Frontend/Ticketing/register.html.twig', array(
            'ticketQuantity' => $ticketQuantity,
            'form' => $form->createView(),
        )));
    }

    public function checkout (Environment $twig, RouterInterface $router, Request $request, StripePayment $stripePayment):Response
    {
        $session = $request->getSession();
        $currentBooking = $session->get('booking');

        if (($request->get('stripeToken')) && ($request->get('card_name'))) {
            // If card is valide
            if ($stripePayment->stripePayment()) {

                $url = $router->generate('booking_success');
                return new RedirectResponse($url);
            }
        }

        return new Response($twig->render('Frontend/Ticketing/checkout.html.twig', array(
            'amount' => $currentBooking->getAmount(),
            'ticketQuantity' => $currentBooking->getTicketQuantity(),
            'mail' => $currentBooking->getUserMail(),
            'bookingDate' => $currentBooking->getBookingDate()->format('d/m/y'),
            'tickets' => $currentBooking->getTickets()
        )));
    }

    public function paymentSuccess(EntityManagerInterface $entityManager, Environment $twig, Mailing $mailer, Request $request):Response
    {

        $currentBooking = $request->getSession()->get('booking');
        $commandNumber = $currentBooking->getCommandNumber();
        $bookingDate = $currentBooking->getBookingDate()->format('d/m/Y');
        $userMail = $currentBooking->getUserMail();

        $entityManager->persist($currentBooking);
        $entityManager->flush();
        $request->getSession()->remove('booking');
        $mailer->sendMail($userMail);

        return new Response($twig->render('Frontend/Ticketing/succeed.html.twig',array(
            'commandNumber' => $commandNumber,
            'bookingDate'   => $bookingDate,
            'userMail'      => $userMail
        )));
    }

}