CoinJar API Starter Application
=======================

Introduction
------------
This is a simple application using the CoinJar API.
This application is meant to be used as a starting place for those
looking to Bitcoin solutions with the CoinJar API in php.


Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `create-project` command:

    curl -s https://getcomposer.org/installer | php --

    cd my/project/dir
    git clone https://github.com/jimlyndon/CoinJarExamplePhp.git
    cd CoinJarExamplePhp
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

You would then invoke `composer` to install dependencies per the previous
example.


API Key
-------
Make sure you get an API key from CoinJar.io.  First create an account - best to use the sandbox environment where
you can send and receive fake bitcoins when starting out.  To do this 
[sign up](https://secure.sandbox.coinjar.io/users/sign_in) for a Coinjar Sandbox account.

In your CoinJar sandbox account you can create a "bitcoin address" and send test bitcoin to this address 
from a [Faucet](http://testnet.mojocoin.com/).  You can return to them some test bitcoin as well.  You can create
addresses under your account and send/receive bitcoin, this way you have some test transactional data to work with.

Finally you need to turn on your user API access by going to account settings -> API access -> Enable API.
This will ask you for your credentials and display an API key.

If you're building a merchant application you will also need to 
[retrieve your merchant id and key](https://checkout.sandbox.coinjar.io/merchant/credentials) from your Sandbox account
or from the [live/production Coinjar website](https://checkout.coinjar.io/merchant/credentials)

Currently this example application is only using the user API.  So in the file /module/MyCoinJar/src/MyCoinJar/Controller/MyCoinJarController.php
replace the key in the line `const APIKey = "REPLACE_WITH_YOUR_KEY";` with your API key.


Virtual Host
------------
Afterwards, set up an apache virtual host to point to the public/ directory of the
project and you should be ready to go!  Follow this how-to: http://www.thegeekstuff.com/2011/07/apache-virtual-host/
or the following for simply instructions:

Get root to make Apache changes

    $ sudo su -


Next edit the Apache config:

    root# vi /etc/apache2/httpd.conf

Within this file, find the Virtual hosts section and uncomment the following:

    Include /private/etc/apache2/extra/httpd-vhosts.conf

Save this file.

Next edit the vhosts config:

    root# vi /etc/apache2/extra/httpd-vhosts.conf

Within this file, create a virtual host config, something like:

    <VirtualHost *:80>
        ServerName yourapp.localhost
        DocumentRoot /Users/you/yourapp/public
        SetEnv APPLICATION_ENV "development"
        <Directory /Users/you/yourapp/public>
        SetEnv APPLICATION_ENV "development"
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

Save this file.

Finally restsart Apache:

    root# apachectl restart

Now you should be able to navigate to your site at `http://yourapp.localhost/`

Direct any issues/problems/questions/complaints @jimlyndon  :)
