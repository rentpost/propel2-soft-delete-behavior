/**
 * Enable the soft_delete behavior for this model
 */
public static function enableSoftDelete(): void
{
    self::$softDelete = true;
}
