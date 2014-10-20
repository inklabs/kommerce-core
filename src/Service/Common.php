<?php
namespace inklabs\kommerce\Service;

trait Common
{
    public function findByEncodedId($encodedId)
    {
        $id = BaseConvert::decode($encodedId);
        return $this->find($id);
    }
}
