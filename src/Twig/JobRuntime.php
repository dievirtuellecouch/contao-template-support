<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class JobRuntime implements RuntimeExtensionInterface
{
    /**
     * Group types with their CSS color classes
     */
    private const GROUP_TYPES = [
        'CUSTOM_4' => 'headline_orange',
        'CUSTOM_5' => 'headline_green',
        'CUSTOM_6' => 'headline_yellow',
        'CUSTOM_7' => 'headline_red',
    ];

    /**
     * Groups job items by their employment type and extracts relevant data
     *
     * @param array $items Array of pre-rendered HTML job items
     * @return array Grouped array with structure: [groupType => ['name' => string, 'color' => string, 'items' => array]]
     */
    public function groupJobsByEmploymentType(array $items): array
    {
        $sortedGroups = [];
        $groupNames = [];

        foreach ($items as $item) {
            // Extract employment types from data attribute
            $employmentTypes = $this->extractAttribute($item, 'data-job-employment-type');
            $employmentTypeNames = $this->extractAttribute($item, 'data-job-employment-type-names');

            if (empty($employmentTypes)) {
                continue;
            }

            $typesArray = explode(',', $employmentTypes);
            $namesArray = explode(', ', $employmentTypeNames);
            $typesMap = array_combine($typesArray, $namesArray);

            // Find matching group types
            $matchingGroups = array_intersect_key($typesMap, self::GROUP_TYPES);

            foreach ($matchingGroups as $groupType => $groupName) {
                $groupNames[$groupType] = $groupName;

                if (!isset($sortedGroups[$groupType])) {
                    $sortedGroups[$groupType] = [];
                }
                $sortedGroups[$groupType][] = $item;
            }
        }

        // Build result array with metadata
        $result = [];
        foreach ($sortedGroups as $groupType => $groupItems) {
            $result[$groupType] = [
                'name' => $groupNames[$groupType] ?? $groupType,
                'color' => self::GROUP_TYPES[$groupType] ?? '',
                'items' => $groupItems,
            ];
        }

        return $result;
    }

    /**
     * Get the color class for a given employment type
     */
    public function getJobColorClass(string $employmentType): string
    {
        return self::GROUP_TYPES[$employmentType] ?? '';
    }

    /**
     * Extract attribute value from HTML string
     */
    private function extractAttribute(string $html, string $attribute): string
    {
        $pattern = '/' . preg_quote($attribute, '/') . '="([^"]*)"/';
        if (preg_match($pattern, $html, $matches)) {
            return html_entity_decode($matches[1]);
        }
        return '';
    }
}
