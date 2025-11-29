<?php

namespace DVC\TemplateSupport\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class TextRuntime implements RuntimeExtensionInterface
{
    const CSS_CLASS_VARIATION_DELIMITER = '_';

    /**
     * Return a list of CSS variation class names.
     * Check if a value for each allowed variation name
     * exits in the given context. Boolean "true" values
     * will be added with their name only while variations
     * with an defined value have the scheme {name}-{value}.
     *
     * @param string $baseClass The base class each variation depends on.
     * @param array $allowedVariationNames The flat list of variation names to add.
     * @param array $context The context should contain the variation values.
     * @return array List of class names.
     */
    public function makeCssClassVariations(
        string $baseClass,
        array $allowedVariationNames,
        array $context
    ): array {
        $variationValues = \array_filter($allowedVariationNames, function($variationName) use ($context) {
            return \array_key_exists($variationName, $context) && !empty($context[$variationName]);
        });

        $classesForVariations = \array_map(function($variationName) use ($context) {
            $variationValue = $context[$variationName];

            $variationName = $this->kebabCase($variationName);

            if ($variationValue === true) {
                return $variationName;
            }

            return \sprintf('%s-%s', $variationName, $variationValue);

        }, $variationValues);

        return \array_map(fn ($variationClass) => $baseClass . self::CSS_CLASS_VARIATION_DELIMITER . $variationClass, $classesForVariations);
    }

    /**
     * Convert given string to kebab-case.
     *
     * @param string $text Input text.
     * @return string In kebab-case.
     */
    public function kebabCase(string $text): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $text));
    }

    /**
     * URL decodes given string.
     *
     * @param string URL encoded string
     * @return string URL decoded string
     */
    public function urlDecode(string $url): string
    {
        return urldecode($url);
    }

    /**
     * Wrap occurrences of (m/w/d) with a <sub> tag.
     * Handles optional spaces and non-breaking spaces between characters.
     */
    public function wrapMwdSub(string $text): string
    {
        if (false !== strpos($text, '<sub>')) {
            return $text;
        }

        // Normalize common NBSP variants to regular space for matching, but keep original text for output
        $normalized = str_replace(["\xC2\xA0", '&nbsp;'], ' ', $text);

        // Match only (m/w/d) with optional spaces (including unicode spaces) between characters
        $pattern = '/\s*\((?:\h|\x{00A0})*m(?:\h|\x{00A0})*\/(?:\h|\x{00A0})*w(?:\h|\x{00A0})*\/(?:\h|\x{00A0})*d(?:\h|\x{00A0})*\)/u';

        if (!preg_match($pattern, $normalized)) {
            return $text;
        }

        // Replace in normalized copy then return the modified string
        $replaced = preg_replace($pattern, ' <sub>(m/w/d)</sub>', $normalized);

        return $replaced ?? $text;
    }
}
