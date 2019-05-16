if (<?= $classname ?>::isSoftDeleteEnabled() && $this->localSoftDelete) {
    return $this->softDelete($con);
} else {
    return $this->hasWhereClause() ? $this->forceDelete($con) : $this->forceDeleteAll($con);
}
