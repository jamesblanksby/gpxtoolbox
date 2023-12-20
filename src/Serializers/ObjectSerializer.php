<?php

namespace GPXToolbox\Serializers;

class ObjectSerializer
{
    /**
     * Serialize an object.
     *
     * @param object $object
     * @return mixed
     * @throws \UnexpectedValueException If no suitable serialization method is found for the object.
     */
    public static function serialize(object $object)
    {
        if (method_exists($object, 'toArray')) {
            return $object->toArray();
        }

        if (method_exists($object, 'toString')) {
            return $object->toString();
        }

        throw new \UnexpectedValueException(sprintf('No serializer found for: %s', get_class($object)));
    }
}
