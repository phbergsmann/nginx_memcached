.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration Reference
=======================

On the nginx-side you have to add one location-directive to your configuration:

.. code-block:: nginx

	location / {
		 default_type text/html;
		 set $memcached_key "$uri?$args";
		 memcached_pass 127.0.0.1:11211;
		 error_page 404 502 504 = @fallback;
	}

+----------------+---------------+----------------------------------------------+
| Parameter      | Data type     | Description                     	            |
+================+===============+==============================================+
| default_type   | string        | mime-type of the returned document           |
+----------------+---------------+----------------------------------------------+
| $memcached_key | string        | definition of the key format                 |
+----------------+---------------+----------------------------------------------+
| memcached_pass | string        | memcached-server-configuration: address:port |
+----------------+---------------+----------------------------------------------+
| error_page     | string        | the "fallback-location"                      |
+----------------+---------------+----------------------------------------------+

As you can see, you need a "fallback-location" if the requested page is not cached. All you have to do is to change
your existing location-directive from

.. code-block:: nginx

	location / {

to

.. code-block:: nginx

	location @fallback {


More specific documentation can be found at the `nginx memcached module documentation`_.

.. _nginx memcached module documentation: http://nginx.org/en/docs/http/ngx_http_memcached_module.html