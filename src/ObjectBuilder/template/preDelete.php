if (!$ret) {
    $this-><?= $setter ?>(time());
    $this->save($con);

    <?php if ($addHooks): ?>
        $this->postDelete($con);
    <?php endif; ?>

    $con->commit();

    <?= $classname ?>TableMap::removeInstanceFromPool($this->getPrimaryKey());
}
