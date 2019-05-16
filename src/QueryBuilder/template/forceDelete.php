/**
 * Bypass the soft_delete behavior and force a hard delete of the selected rows
 *
 * @param ConnectionInterface|null $con     An optional connection object
 *
 * @return int                              Number of deleted rows
 */
public function forceDelete(?ConnectionInterface $con = null)
{
    return $this->delete($con);
}
