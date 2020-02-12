<?php

namespace App\Services;





use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class StripePayment
{

    private $request;

    private $flashBag;

    public function __construct(RequestStack $request, FlashBagInterface $flashBag)
    {
        $this->request = $request;
        $this->flashBag = $flashBag;
    }

    /**
     * @return bool
     */
    public function stripePayment():bool
    {

        $request = $this->request->getCurrentRequest();
        $currentBooking = $request->getSession()->get('booking');

            $error = false;
            try {
                \Stripe\Stripe::setApiKey("sk_test_6G64v0ymQwWDFy39GaA6pPTD");
                // Token is created using Checkout or Elements!
                // Get the payment token ID submitted by the form:
                $token = $request->get('stripeToken');
                $cardName = $_POST['card_name'];

                // Create a custumer on stripe account
                $customer = \Stripe\Customer::create(array(
                    "source" => $token,
                    "email" => $currentBooking->getUserMail(),
                    "description" => "",
                    "metadata" => array('Name' => $cardName)
                ));

                // Submit the payment
                \Stripe\Charge::create(array(
                    "amount" => $currentBooking->getAmount() * 100,
                    "currency" => "eur",
                    "description" => "Example charge",
                    "customer" => $customer->id
                ));

                return true;


            } catch (\Stripe\Error\Card $e) {
                $error = 'there was a problem charging your card: ' . $e->getMessage();
                $this->flashBag->add('error', 'Un problème est survenu. Veuillez vérifier vos coordonnées bancaires.');
            }
            return false;
        }


    }


