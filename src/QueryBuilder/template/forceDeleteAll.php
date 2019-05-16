/**
 * Bypass the soft_delete behavior and force a hard delete of all the rows
 *
 * @param ConnectionInterface|null $con     An optional connection object
 *
 * @return int                              Number of deleted rows
 */
public function forceDeleteAll(?ConnectionInterface $con = null)
{
    return $this->deleteAll($con);
}
