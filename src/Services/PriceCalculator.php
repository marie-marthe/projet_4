<?php

namespace App\Services;


/*
 * Getprice()
 */
use App\Entity\Ticket;

class PriceCalculator
{
    /**
     * @param $birthDate
     * @param $discount
     * @return string
     */
    private function getProfileByAge($birthDate, $discount):string
    {
        // Convert birthDate into age
        $today = new \DateTime();
        $age = (int)$today->diff($birthDate)->format('%y');


        // Looking for profile
        $profile = '';

        if ($discount){
            $profile = 'discount';
        } elseif ($age >= 4 && $age <= 12) {
            $profile = 'child';
        } elseif ($age > 12 && $age < 60) {
            $profile = 'normal';
        } elseif ($age >= 60) {
            $profile = 'elder';
        }

        return $profile;
    }

    /**
     * @param Ticket $ticket
     * @return mixed
     */
    public function calculating(Ticket $ticket):int
    {
        $birthDate = $ticket->getGuestBirthDate();
        $discount = $ticket->getDiscount();

        $guestProfile = $this->getProfileByAge($birthDate, $discount);

        $prices = array(
            'baby'     =>  0,
            'child'    =>  8,
            'normal'   => 16,
            'elder'    => 12,
            'discount' => 10
        );


        $ticketPrice = $prices[$guestProfile];
        $ticket->setPrice($prices[$guestProfile]);

        return $ticketPrice;

    }


}

