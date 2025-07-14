<?php

namespace Config;

/**
 * Mimes
 *
 * This file contains an array of mime types.  It is used by the
 * Upload class to help identify allowed file types.
 */
class Mimes
{
    /**
     * Map of extensions to mime types.
     *
     * @var array<string, list<string>|string>
     */
    public static array $mimes = [
        'txt' => 'text/plain',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
    ];

    /**
     * Attempts to determine the best mime type for the given file extension.
     *
     * @return string|null The mime type found, or null if unable to determine.
     */
    public static function guessTypeFromExtension(string $extension)
    {
        $extension = ltrim(strtolower($extension), '.');

        if (! array_key_exists($extension, static::$mimes)) {
            return null;
        }

        return is_array(static::$mimes[$extension]) ? static::$mimes[$extension][0] : static::$mimes[$extension];
    }

    /**
     * Attempts to determine the best file extension for a given mime type.
     *
     * @param string $type
     *
     * @return string|null The extension determined, or null if unable to match.
     */
    public static function guessExtensionFromType($type, ?string $proposedExtension = null)
    {
        $type = trim(strtolower($type), '. ');

        $proposedExtension = trim(strtolower($proposedExtension ?? ''));

        if (! empty($proposedExtension)) {
            $proposedType = static::guessTypeFromExtension($proposedExtension);

            if ($type === $proposedType) {
                return $proposedExtension;
            }
        }

        // Reverse check
        foreach (static::$mimes as $ext => $types) {
            if ((is_string($types) && $types === $type) || (is_array($types) && in_array($type, $types, true))) {
                return $ext;
            }
        }

        return null;
    }
}
