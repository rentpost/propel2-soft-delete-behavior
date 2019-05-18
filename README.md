# propel2-soft-delete-behavior

This "behavior" provides soft delete support for [Propel2](https://propelorm.org).  Soft deleting was deprecated in Propel2 in favor of the new archivable behavior.  Both have their drawbacks, but admittedly soft delete is a bit inferior.  This behavior will bring back the same Propel1 behavior API and support in Propel2.

## Setup

Just require this behavior with Composer.  Propel supports a specialized Composer `type` known as a `propel-behavior`.

```bash
composer require rentpost/propel2-soft-delete-behavior
```

## Usage

This behavior should be BC with the Propel1 soft_delete behavior.  Therefore, the usage is the same, so feel free to reference any existing documentation regarding soft_delete.

That said, you'll want to add the following to your `schema.xml` file under the `table` element node, defining the column with which you wish to use for the state and timestamp of deletion.

```xml
<behavior name="soft_delete">
  <parameter name="deleted_column" value="deleted_at" />
</behavior>
```
