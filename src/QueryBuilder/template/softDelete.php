/**
 * Soft delete the selected rows
 *
 * @param ConnectionInterface|null $con     An optional connection object
 *
 * @return int                              Number of updated rows
 */
public function softDelete(?ConnectionInterface $con = null)
{
    return $this->update([
        '<?= $deletedColumn ?>' => time()
    ], $con);
}
