/**
 * Undelete a row that was soft_deleted
 *
 * @param ConnectionInterface|null $con
 *
 * @return int   The number of rows affected by this update and any referring fk objects' save() operations.
 */
public function unDelete(?ConnectionInterface $con = null)
{
    $this-><?= $setter ?>(null);

    return $this->save($con);
}
