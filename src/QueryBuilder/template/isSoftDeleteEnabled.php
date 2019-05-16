/**
 * Check the soft_delete behavior for this model
 *
 * @return boolean True if the soft_delete behavior is enabled
 */
public static function isSoftDeleteEnabled(): bool
{
    return self::$softDelete;
}
