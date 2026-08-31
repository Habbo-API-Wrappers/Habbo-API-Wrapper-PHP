<?php

namespace Wiredspast\HabboApiWrapperPhp\Util;

/**
 * Clean up parsed XML arrays to a more usable format
 */
abstract class XmlCleaner
{
    /**
     * Clean up a parsed XML array to a more usable format
     *
     * @param array $xml The parsed XML to clean up
     *
     * @return array The cleaned up XML
     */
    public static function cleanXml(array $xml): array
    {
        $i = 0;
        return self::cleanXmlRec($xml,$i);
    }

    /**
     * Recursively clean up a parsed XML array to a more usable format
     *
     * @param array $xml The parsed XML to clean up
     * @param int $i The index of the next element to process
     *
     * @return array The cleaned up XML
     */
    private static function cleanXmlRec(array $xml, int &$i): array
    {
        $result = [];
        while ($i < count($xml)) {
            $entry = $xml[$i++];
            if (!isset($entry['type'])) {
                continue;
            }

            switch ($entry['type']) {
                case 'open':
                    $result[$entry['tag']] ??= [];
                    $result[$entry['tag']][] = array_merge($entry['attributes'], self::cleanXmlRec($xml, $i));
                    break;
                case 'close':
                    return $result;
                case 'complete':
                    $result[$entry['tag']] ??= [];
                    $result[$entry['tag']][] = $entry['attributes'];
                    break;
                default:
                    break;
            }
        }

        return $result;
    }
}