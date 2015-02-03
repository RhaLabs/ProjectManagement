# Configuring and Getting Bundles

## Setting Up Composer

In the previous sections you downloaded our custom code.  Included in that code was a version of composer.
You can learn all about composer [here](https://getcomposer.org/).  First we need to ensure that your copy
of composer is the most recent.  Change to the directory where you cloned our code.

```shell
        cd /var/www
        php composer.phar selfupdate
```

Next we need to update/install all the dependencies of our project.  We have quite a lot of dependencies and
you might hit the GitHub rate limit.  See the next section for dealing with the rate limit.  To update everything
run:

```shell
        php composer.phar update
```
       
Once it completes (hopefully without errors), you need to set file permissions so that lighttp can use the 
cache files and write logs.

```shell
        sudo apt-get install acl
        sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
        sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
```

*Note* there is a regression [bug](http://debbugs.gnu.org/cgi/bugreport.cgi?bug=8527) in the current Ubuntu which 
is making ACL ineffective.  This means that we need to run the `setfacl` commands above after **every** `php composer.phar update`.
Our update scripts (which you just ran) does this for us.  You may have noticed that after clearing the cache you 
were prompted for your password.  This is why.  Check out the file `composer.json` and you'll see what we're doing.

#### GitHub's Rate Limit

I'm assuming you got hit with the rate limit error which is why you are now reading this.  It is ok really, however you will need
to do a few things and this error will go away.

*   Read about the reason here [rate limit][]
*   Sign up for a GitHub [account](https://github.com/join)
*   [Create](https://github.com/settings/applications) an OAuth token for composer

    -   click the button *Generate new token* and name it something.  I called mine symfony.
    -   **copy the token now** it is the string of random numbers and letters
*   Now add your token to composer. 

```shell
            php composer.phar config -g github-oauth.github.com oauthtoken
```

Replace the word `oauthtoken` above with your copied text from GitHub.

[rate limit]: https://developer.github.com/v3/#rate-limiting

## Updating Code

Updating code is really easy.  There are only 2 commands you need to remember (ok actually 3).

*   `hg pull`
*   `hg update -C`
*   `php composer.phar update`

Now let me explain each of these. First thing first.  Make sure you are in the base web directory:

```shell
        cd /var/www
```
        
It is always good practice to keep all of our dependencies up to date.  Composer will take care to this for us
and will tell us when and how to update composer. So when you run

```shell
        php composer.phar update
```
        
Composer will look in our `composer.json` file to learn about what we want and then get updates to all of our dependent bundles.
Easy right?  Ok, next is updating our project code.  Pretend that I just finished making some changes.  I've tested it locally
and pushed the changes out to our google project page.  You need to get those changes onto the server.

```shell
        hg pull
        hg update -C
```

The code is updated to the latest version.  You aren't done yet but that wasn't difficult was it?  Due to Symfony's 
optimizations after any code gets updated - either our project or the dependencies - we need to tell symfony to regenerate the cache files

```shell
        php app/console cache:clear --env=prod
        php app/console assets:install --env=prod --symlink
        php app/console assetic:dump --env=prod
```
        
Done.  Now you might get errors if you are using Ubuntu and it is because of the bug mentioned eariler.  Run the `setfacl` commands above
and you should be good to go.

## Helper Script

Remembering all those commands and the order of commands to run after you've updated the code is tedious.  I think computers
exist to help us be lazy.  So let's make the computer do some of the remembering!  Get my script

```shell
        wget https://gist.githubusercontent.com/kg4mfq/15afe1f17326158ed8bf/raw/26f9ba162d0d86a28f075e7c07930756c6a18b59/warm-up.sh warm-up.sh
        sudo chmod +x warm-up.sh
```

This script expects to be run from your base project directory; in our case `/var/www` and it expects to find a file called
`parameters.yml.dist`.  I'll explain this file later.  So after you've updated dependencies and/or our project code just run this script

```shell
        ./warm-up.sh
```

It'll ask you for your password in order to set the ACL.
        
