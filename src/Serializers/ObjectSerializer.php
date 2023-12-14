<?php

namespace GPXToolbox\Serializers;

final class ObjectSerializer
{
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
