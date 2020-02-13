<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketingControllerTest extends WebTestCase
{
    public function testBookingHomePage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/booking');

        $form = $crawler->selectButton('Valider')->form();

        $form['booking[bookingDate]'] =(new \DateTime('2019/02/01'))->format('d-m-Y');
        $form['booking[ticketCategory]'] = true;
        $form['booking[userMail]'] = 'd.delima@outlook.fr';
        $form['booking[ticketQuantity]'] = 1;
        $client->submit($form);

        $client->followRedirect();


        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

}