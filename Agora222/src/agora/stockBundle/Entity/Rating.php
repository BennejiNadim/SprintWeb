<?php


namespace agora\stockBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity
 */

class Rating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="string", length=255, nullable=true)
     */
    private $feedback;
    /**
     * @var integer
     *
     * @ORM\Column(name="ratings", type="integer")
     */
    private $ratings;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param string $feedback
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * @return int
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @param int $ratings
     */
    public function setRatings($ratings)
    {
        $this->ratings = $ratings;
    }

}