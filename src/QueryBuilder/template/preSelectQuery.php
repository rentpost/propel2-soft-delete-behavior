if (<?= $classname ?>::isSoftDeleteEnabled() && $this->localSoftDelete) {
    $this->filterBy<?= $deletedColumn ?>(null);
} else {
    $this->enableSoftDelete();
}
