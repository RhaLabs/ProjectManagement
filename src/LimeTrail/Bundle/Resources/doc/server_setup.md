# Setting up the Server

## The OS

We are using Ubuntu 14.04LTS server.  Why Ubuntu?  There are a couple of reasons.

*   It is open source with an active community and backed by a known company
    
    What does this mean?
    -   Open source: if you don't like something, you can change it.
    -   If you get stuck you can get help from the community
    -   You can get paid support from [Canonical](http://www.canonical.com/)

*   Ubuntu provides security updates and patches for 5 years (on the LTS versions)
*   Server software runs more recent versions of code than comparable linux editions such as RedHat or CentOs.

    -   This is important becuase the version of Symfony we run requires recent versions of PHP and other backend system
    
*   Updating software and installing new software is really easy with the command
        
        sudo apt-get install <package-name>

*   When a new version of the entire OS is available we can easily upgrade the entire system
        
        sudo dist-upgrade

## Server Software

After installing the default OS we need to install additional software.  We refer to each software as a "package".
This is becuase the entire system is modular.  You can install and remove any and all packages to adapt the OS to exactly how you need it.
This is something you really can't do on MicroSoft products.

Each package defines how it gets installed and what it needs to run.  So if you want to install a package but don't have all the pieces,
the package manager `apt-get` will figure out what you need and install it.

At the minimum you'll need a webserver, a database, and php.  We use lighttpd, mysql, and php5 and the rest of this documentation will
focus on these.  You are not locked in to using what we use but you'll need to refer to the documentation provided by your packages.

### Installing the packages

Let's get started installing.  First let's get a webserver, php, and mysql going. Type or copy/paste the following into a terminal.
        
        sudo apt-get install php5-cli php5-common php5-cgi mysql-client mysql-common mysql-server php5-mysql php-pear php5-xcache php5-intl php5-fpm

When you run PHP on a webserver you really need a cacher - we're using xcache which you installed with the command above.
Symfony will complain if you don't enable a cacher so let's do that
        
        sudo lighty-enable-mod fastcgi
        sudo lighty-enable-mod fastcgi-php
    
### Get the code

At this point all we have is a basic webserver and database but no content or anything special.  Our website code for Symfony
is hosted on code.google.com at <https://code.google.com/p/limetrail/>.
Inorder to get this code you'll need a program called mercurial.  Getting it is easy `sudo apt-get install mercurial`.
We're going to clone (i.e. copy) the code to a location that the webserver (lighttpd) knows about.  A common place is `/var/www`.
        hg clone https://code.google.com/p/limetrail/ /var/www
We'll talk about getting our virtual hosts setup later.

### More packages to install

The code we just downloaded needs a few other packages.  And we need to configure a few file permissions.
We need a mail transport agent and npm.
        
        sudo apt-get install postfix npm
        
Setting up postfix is [here](/trail/docs/setting_up_postfix.md)
We need to have lessc to compile our site themes.  We need uglifyjs to compress our javascripts. We need uglifycss to compress our css files.
The idea here is to minimize the amount of data we send over the network by removing whitespace and extra, unnecessary characters.
        
        sudo npm install -g lessc
        sudo npm install -g uglifycss
        sudo npm install -g uglifyjs
        
Our web code and the assetic bundle expects to find the nodejs binary at `/usr/bin/node` but on Ubuntu it gets installed at `/usr/bin/nodejs`.
We just need a symbolic link
        
        sudo ln -s /usr/bin/nodejs /usr/bin/node

### Security packages

Our server, right now, is wide open and isn't doing anything to help us.
**TODO:  finish this section**
        
        sudo apt-get install logwatch tripwire fail2ban
        
Create some firewall rules.  Get the file from [iptables.sh][] and by 
        
        cd ~/
        wget https://gist.githubusercontent.com/kg4mfq/be98cb7afb29dc8dcedf/raw/8a1c7e569a163b55719dfbf15d40f2512f176711/iptables.sh iptables.sh
        sudo chmod +x iptables.sh
        ./iptables.sh
        
[iptables.sh]: https://gist.githubusercontent.com/kg4mfq/be98cb7afb29dc8dcedf/raw/8a1c7e569a163b55719dfbf15d40f2512f176711/iptables.sh


