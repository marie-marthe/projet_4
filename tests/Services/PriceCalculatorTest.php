<?php

namespace App\Tests\Services;

use App\Entity\Ticket;
use App\Services\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{

    /**
     * @dataProvider ticketsForCalculator
     */
    public function testPriceCalculator($ticketData, $priceExpected)
    {
        $priceCalculator = new PriceCalculator();
        $this->assertSame($priceExpected,$priceCalculator->calculating($ticketData));
    }

    public function ticketsForCalculator()
    {

        $ticket_discount = new Ticket();
        $ticket_discount->setGuestBirthDate(new \DateTime());
        $ticket_discount->setDiscount(true);

        $ticket_child = new Ticket();
        $ticket_child->setGuestBirthDate(new \DateTime('2010-01-01'));
        $ticket_child->setDiscount(false);

        $ticket_normal = new Ticket();
        $ticket_normal->setGuestBirthDate(new \DateTime('2000-01-01'));
        $ticket_normal->setDiscount(false);

        $ticket_elder = new Ticket();
        $ticket_elder->setGuestBirthDate(new \DateTime('1945-01-01'));
        $ticket_elder->setDiscount(false);


        return [
            [$ticket_discount, 10],
            [$ticket_child, 8],
            [$ticket_normal, 16],
            [$ticket_elder, 12]

        ];

    }
}