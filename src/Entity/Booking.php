<?php

namespace App\Entity;

use App\Validator\Constraints\CheckDate;
use App\Validator\Constraints\CheckOverTickets;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="booking", cascade={"persist"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="date", name="booking_date")
     * @Assert\NotBlank()
     * @Assert\Date()
     * @CheckDate()
     */
    private $booking_date;

    /**
     * @ORM\Column(type="integer", name="command_number")
     */
    private $commandNumber;

    /**
     * @ORM\Column(type="boolean", name="booking_ticketCategory")
     * @Assert\Type(type="bool")
     */
    private $ticketCategory;

    /**
     * @ORM\Column(type="string", name="booking_userMail")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $userMail;

    /**
     * @ORM\Column(type="integer", name="booking_ticketQuantity")
     * @CheckOverTickets()
     * @Assert\NotNull()
     */
    private $ticketQuantity;

    /**
     * @ORM\Column(type="integer", name="booking_amount")
     */
    private $amount;


    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBookingDate()
    {
        return $this->booking_date;
    }

    /**
     * @param mixed $booking_date
     */
    public function setBookingDate($booking_date): void
    {
        $this->booking_date = $booking_date;
    }

    /**
     * @return mixed
     */
    public function getTicketCategory()
    {
        return $this->ticketCategory;
    }

    /**
     * @param mixed $ticketCategory
     */
    public function setTicketCategory($ticketCategory): void
    {
        $this->ticketCategory = $ticketCategory;
    }

    /**
     * @return mixed
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * @param mixed $userMail
     */
    public function setUserMail($userMail): void
    {
        $this->userMail = $userMail;
    }

    /**
     * @return mixed
     */
    public function getTicketQuantity()
    {
        return $this->ticketQuantity;
    }

    /**
     * @param mixed $ticketQuantity
     */
    public function setTicketQuantity($ticketQuantity): void
    {
        $this->ticketQuantity = $ticketQuantity;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        //  lie la réservation avec le Billet
        $ticket->setBooking($this);

        return $this;
    }

    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * @return mixed
     */
    public function getCommandNumber()
    {
        return $this->commandNumber;
    }

    /**
     * @param mixed $commandNumber
     */
    public function setCommandNumber($commandNumber): void
    {
        $this->commandNumber = $commandNumber;
    }


}
