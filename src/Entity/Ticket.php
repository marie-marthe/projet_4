<?php

namespace App\Entity;

use App\Validator\Constraints\CheckBirthDate;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;

    /**
     * @ORM\Column(type="string", name="ticket_GuestFirstName")
     * @Assert\NotBlank()
     * @Assert\Length(min="3", minMessage=" Votre Prénom n'est pas valide. Il doit contenir au moins 3 caractères")
     */
    private $guestFirstName;

    /**
     * @ORM\Column(type="string", name="ticket_GuestLastName")
     * @Assert\NotBlank()
     * @Assert\Length(min="3", minMessage="Votre Nom n'est pas valide. Il doit contenir au moins 3 caractères")
     */
    private $guestLastName;

    /**
     * @ORM\Column(type="string", name="ticket_guestCountry")
     * @Assert\Country(message="Le pays n'est pas valide.")
     */
    private $guestCountry;

    /**
     * @ORM\Column(type="date", name="ticket_guestBirthDate")
     * @Assert\NotBlank()
     * @Assert\Date()
     * @CheckBirthDate()
     */
    private $guestBirthDate;

    /**
     * @ORM\Column(type="boolean", name="ticket_discount")
     * @Assert\Type(type="bool")
     */
    private $discount;

    /**
     * @ORM\Column(type="integer", name="ticket_price")
     * @Assert\Type(type="integer")
     */
    private $price;

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
    public function getGuestFirstName()
    {
        return $this->guestFirstName;
    }

    /**
     * @param mixed $guestFirstName
     */
    public function setGuestFirstName($guestFirstName): void
    {
        $this->guestFirstName = $guestFirstName;
    }

    /**
     * @return mixed
     */
    public function getGuestLastName()
    {
        return $this->guestLastName;
    }

    /**
     * @param mixed $guestLastName
     */
    public function setGuestLastName($guestLastName): void
    {
        $this->guestLastName = $guestLastName;
    }

    /**
     * @return mixed
     */
    public function getGuestCountry()
    {
        return $this->guestCountry;
    }

    /**
     * @param mixed $guestCountry
     */
    public function setGuestCountry($guestCountry): void
    {
        $this->guestCountry = $guestCountry;
    }

    /**
     * @return mixed
     */
    public function getGuestBirthDate()
    {
        return $this->guestBirthDate;
    }

    /**
     * @param mixed $guestBirthDate
     */
    public function setGuestBirthDate($guestBirthDate): void
    {
        $this->guestBirthDate = $guestBirthDate;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * @param mixed $booking
     */
    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }




}
