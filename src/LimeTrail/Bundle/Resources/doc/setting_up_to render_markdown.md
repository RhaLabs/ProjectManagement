# Setup Symfony and Bundles to render markdown files

## Installation

We're using bundles ~~VarspollPygmentsbundle see the bundles [documentation](https://github.com/varspool/PygmentsBundle)~~ 
[KnpMarkdownBundle](https://github.com/KnpLabs/KnpMarkdownBundle)
Following the instructions you need to 

```shell
    sudo pecl install sundown-beta
```
    
Then add `extension=sundown.so` to your php.ini file
Following the debian/Ubuntu way I created a new file named *sundown.ini* in `/etc/php5/mods-available`.
In the body of this file i added the line `extension=sundown.so`.  Then enable the extensions

```shell
        cd /etc/php5/cgi/conf.d
        sudo ln -s ../../mods-available/sundown.ini 20-sundown.ini
```
    
Then reload the configuration and check that the extension is working

```shell
        sudo /etc/init.d/lighttpd force-reload
        /usr/bin/php-cgi -i | grep sundown
```

Next check that python-pygments is installed

```shell
    sudo apt-get install python-pygments
```
    
Follow the remaining steps in the bundle's documentation.  Do note that the path the pygementize is 
at `/usr/bin/pygmentize`
