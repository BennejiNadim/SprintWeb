<?php
/**
 * Created by PhpStorm.
 * User: jha
 * Date: 10/04/2020
 * Time: 23:01
 */

namespace VenteBundle\Listener;



use AncaRebeca\FullCalendarBundle\Model\Event;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;
use GestionEventBundle\Entity\Reservation;

class EventListener
{
    /**
     * @var EntityManager
     */
    private $em;
    private $container;
    public function __construct(EntityManagerInterface $em,\Psr\Container\ContainerInterface $container,Security $security)
    {
        $this->em = $em;
        $this->container = $container;
        $this->security=$security;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(\AncaRebeca\FullCalendarBundle\Event\CalendarEvent $calendarEvent)
    {


        $query = $this->em->createQuery("select e from VenteBundle:Commande c inner join VenteBundle:Livraison e with c.livraison = e ");
        //$query->setParameter(1,$this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $plannings = $query->getResult();


        foreach ($plannings as $p) {
            $date = \DateTime::createFromFormat('d/m/Y', $p->getDate()->format('d/m/Y'));
            $e =  new Event("Commande : " . $p->getCommande()->getId() , $date);


            $calendarEvent->addEvent($e);
        }



    }
}