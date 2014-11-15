.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
============


.. _what-it-does:

What does it do?
----------------

This extension hooks into the page-rendering process and adds the whole page-HTML to memcached with an identifier which
is retrievable via nginx. Using this extension and configurin your nginx to use memcached you can completely
bypass the php interpreter, which results in an amazing speed improvement because you deliver your pages directly
from memory.