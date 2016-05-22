<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Attachment implements UuidEntityInterface, ValidationInterface
{
    use TimeTrait, UuidTrait;

    /** @var bool */
    protected $isVisible;

    /** @var bool */
    protected $isLocked;

    /** @var string */
    private $uri;

    /** @var OrderItem[] */
    private $orderItems;

    /**
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->setId();
        $this->setCreated();
        $this->setUri($uri);
        $this->setVisible();
        $this->setUnlocked();
        $this->orderItems = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('uri', new Assert\NotBlank);
        $metadata->addPropertyConstraint('uri', new Assert\Length([
            'max' => 255,
        ]));
    }

    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    private function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function isVisible()
    {
        return $this->isVisible;
    }

    public function setNotVisible()
    {
        $this->isVisible = false;
    }

    private function setVisible()
    {
        $this->isVisible = true;
    }

    public function isLocked()
    {
        return $this->isLocked;
    }

    public function setLocked()
    {
        $this->isLocked = true;
    }

    public function setUnlocked()
    {
        $this->isLocked = false;
    }

    public function addOrderItem(OrderItem $orderItem)
    {
        $this->orderItems->add($orderItem);
    }
}
