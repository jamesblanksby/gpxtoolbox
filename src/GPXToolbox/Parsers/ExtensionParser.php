<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\GPXToolbox;

class ExtensionParser
{
    /**
     * Parses extension data.
     * @param \SimpleXMLElement $nodes
     * @return array
     */
    public static function parse($nodes): array
    {
        $extensions = [];

        $namespaces = $nodes->getNamespaces(true);

        foreach ($namespaces as $nodeNamespace) {
            foreach (GPXToolbox::$EXTENSIONS as $extension) {
                $extensionNamespace = $extension::EXTENSION_NAMESPACE;
                $extensionNamespace = is_array($extensionNamespace) ? $extensionNamespace : [$extensionNamespace,];

                if (!in_array($nodeNamespace, $extensionNamespace)) {
                    continue;
                }

                $node = $nodes->children($nodeNamespace)->{$extension::EXTENSION_NAME};

                $extensions []= $extension::EXTENSION_PARSER::parse($node);
            }
        }

        return $extensions;
    }
}
