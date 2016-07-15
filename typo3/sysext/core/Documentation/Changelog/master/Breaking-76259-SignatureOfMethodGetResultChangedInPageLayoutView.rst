=====================================================================
Breaking: #76259 - Signature of getResult() in PageLayoutView changed
=====================================================================

Description
===========

As part of the migration of the core code to use Doctrine the signature of the method
:php:``PageLayoutView::getResult()`` was changed.

Instead of accepting :php:``bool``, :php:``\mysqli_result`` or :php:``object`` as a
result provider only :php:``\Doctrine\DBAL\Driver\Statement`` objects are accepted.

The new signature is:

.. code-block:: php

    public function getResult(\Doctrine\DBAL\Driver\Statement $result, string $table = 'tt_content'): array
    {
    }


Impact
======

3rd party extensions using :php:``PageLayoutView::getResult()`` need to provide the correct
input type, otherwise exceptions of type :php:``InvalidArgumentException`` will be thrown.


Affected Installations
======================

Installations using 3rd party extensions that use :php:``PageLayoutView::getResult()``.


Migration
=========

Migrate all code that works with the :php:``PageLayoutView::getResult()`` to provide the expected
Doctrine Statement object.
