if ($ret && <?= $modelClassname ?>Query::isSoftDeleteEnabled()) {
    $this-><?= $setter ?>(time());
    $this->save($con);

    <?php if ($addHooks): ?>$this->postDelete($con);<?php endif; ?>

    $con->commit();

    <?= $tableClassname ?>::removeInstanceFromPool($this->getPrimaryKey());

    return;
}
