# Magento 2 CORS Cross-Domain Requests by SplashLab

This module allows you to enable Cross-Origin Resource Sharing (CORS) REST API requests in Magento 2 by adding the appropriate HTTP headers and handling the pre-flight OPTIONS requests.

This can be used to allow AJAX and other requests to the Magento 2 REST API from another domain (or subdomain). 

## How to install

### 1. via composer

Edit `composer.json`

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/splashlab/magento-2-cors-requests"
        }
    ],
    "require": {
        "splashlab/magento-2-cors-requests": "dev-master"
    }
}
```

```
composer install
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

### 2. Copy and paste

Download latest version from GitHub

Paste into `app/code/SplashLab/CorsRequests` directory

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

### 3. Update Origin URL

In `Stores -> Configuration`, go to `General -> Web -> CORS Requests Configuration`.

Then edit the the `CORS Origin Url` field to the domain you want to enable cross-domain requests from. (i.e. http://example.com)

## How does it work?

The full implementation of CORS cross-domain HTTP requests is outside the scope of this README, but this is what this module does:

1. Allows onfigureing an Origin Url in the Admin Configuration area - this is the domain which cross-domain requests are permitted from
2. This domain is added to a `Access-Control-Allow-Origin` response HTTP header
3. Optionally you can enable the `Access-Control-Allow-Credentials` header as well, to enable passing cookies

For non-GET and non-standard-POST requests (i.e. PUT and DELETE), the "pre-flight check" OPTIONS request is handled by:

1. An empty `/V1/cors/check` API response with the appropriate headers:
2. `Access-Control-Allow-Methods` response header, which mirrors the `Access-Control-Request-Method` request header
3. `Access-Control-Allow-Headers` response header, which mirrors the `Access-Control-Request-Headers` request header

### Alternative Solutions

You can also manage these CORS headers with Apache and Nginx rules, instead of using this extension:

- https://community.magento.com/t5/Magento-2-Feature-Requests-and/API-CORS-requests-will-fail-without-OPTIONS-reponse/idi-p/60551
- https://stackoverflow.com/questions/35174585/how-to-add-cors-cross-origin-policy-to-all-domains-in-nginx

But I created this extension to allow you to configure the Origin domain the Admin Configuration, and to avoid having to create and manage special server configuration.

## CORS Cross-Domain Request References

- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://www.html5rocks.com/en/tutorials/cors/
- https://stackoverflow.com/questions/29954037/how-to-disable-options-request
- https://stackoverflow.com/questions/12320467/jquery-cors-content-type-options
- https://github.com/magento/magento2/issues/8399




