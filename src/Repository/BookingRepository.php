<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }


    public function findBookingByDate($bookingDate)
    {
        $qb =  $this->createQueryBuilder('b');

        $qb
            ->innerJoin('b.tickets', 't')
            ->addSelect('t')
        ;
        $qb
            ->where('b.booking_date = :bookingDate')
            ->setParameter('bookingDate', $bookingDate);

        return $qb
            ->getQuery()
            ->getResult();
    }

}
