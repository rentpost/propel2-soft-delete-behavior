/**
 * Undelete selected rows
 *
 * @param ConnectionInterface|null $con     An optional connection object
 *
 * @return int                              The number of rows affected by this update and any
 *                                          referring fk objects' save() operations.
 */
public function unDelete(?ConnectionInterface $con = null)
{
    return $this->update(['<?= $deletedColumn ?>'] => null), $con);
}
