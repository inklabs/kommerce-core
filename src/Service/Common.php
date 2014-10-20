<?php
namespace inklabs\kommerce\Service;

trait Common
{
    public function findByEncodedId($encodedId)
    {
        $id = Base::decode($encodedId);
        return $this->find($id);
    }
}
