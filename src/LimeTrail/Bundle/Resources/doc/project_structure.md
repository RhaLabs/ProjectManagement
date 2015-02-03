# The Project
-------------
This article will be divided into three sections.  The first to talk about the main website and the second to talk about 
the project management website.  The last section will talk about the site theme.

[Symfony]: http://symfony.com/doc/current/index.html "Symfony Documentation"
[rhacms]: https://code.google.com/p/rha-cms/ "Rha Website"
[limetrail]: https://code.google.com/p/limetrail/ "Rha Project Management"
[doctrine-orm]: http://www.doctrine-project.org/projects/orm.html "Doctrine Object Relational Mapper"
[doctrine-odm]: http://www.doctrine-project.org/projects/phpcr-odm.html "Doctrine Object Document Mapper"

## The Main Website

I highly advise that you at least read the intro and basic tutorial [Symfony][].  It will help you follow along.
The main Rha website is a hybrid approach.  It isn't exactly a Content Management System like WordPress or Drupal
but it does offer some dynamic content.

If you look in the `composer.json` file you'll see that we're using the bundles from the Symfony Standard Edition 
along with several other bundles.  You should look these up on GitHub if you want to know exactly what they do.
What is important to note is that the overall configuration is not that different from a standard symfony.

#### Database Layer

Now head over to the `src/Rha/ContentBundle/Resources/config/services.xml` file.  Take a look at the element

```xml
        <service id="rha_content.phpcr.initializer"
                 class="Doctrine\Bundle\PHPCRBundle\Initializer\GenericInitializer">
            <argument>RhaContentBundle Basepaths</argument>
            <argument type="collection">
                <argument>/cms/content</argument>
                <argument>/cms/home</argument>
                <argument>/cms/portfolio</argument>
                <argument>/cms/about</argument>
                <argument>/cms/contact</argument>
                <argument>/cms/about/mission</argument>
                <argument>/cms/about/culture</argument>
                <argument>/cms/about/us</argument>
            </argument>
            <tag name="doctrine_phpcr.initializer"/>
        </service>
```

Notice those lines like `<argument>/cms/contact</argument>`?  Those are the paths in the database where we are going token
store the page content.  So the page at </contact> will look in the database at `/cms/contact` and show whatever
is there.  This lets us have semi-static pages; meaning you can't just add and delete pages on the fly but you can 
*edit* the content of those pages.

#### Controllers and Routing

Open the file `/src/Rha/ContentBundle/Controller/IndexController.php`.  The structure and annotations should be familiar to you 
if you have a general understanding of [Symfony][]. I want to explain how the controller is loading the correct content from the database.
The [doctrine-odm][] documentation isn't very clear yet.  In the function

```php
    public function indexAction()
```

you'll see the line

```php
    $qb->where()->child("/cms/home", 'c');
```

this is the magic.  In each controller where we match a route for a page we need to look up the **child node** 
from Doctrine.  In this case `/cms/home`.  When we execute the database query we get all of the content at the node 
which is then sent to the Twig template to be rendered into the page's html.

In order to edit the content you need to login go to the [admin](/admin) page and use the admin acount.  The default 
action is to redirect you to the homepage however you can get to the admin dashboard now [dashboard](/admin/dashboard).
In the dashboard you can navigate the content tree and add or delete or edit the content nodes by right-click on the node.

## Project Management Website

This one is based on the [Symfony][] for the Standard Edition.  To load data into the grids we're using the well documented 
[doctrine-orm][].  The ORM is basically an agnostic database mapper.  To get the grids we use the [ThraceDatagridBundle](https://github.com/thrace-project/datagrid-bundle)
To make the grids responsive we respond to grid events and modify the query.  We also have a grid service which formats our
grid for us.  Using the service ensures that all of the grids look the same and we don't have duplicate code.

## Site Theme

We're using the Twitter Bootstrap to theme the site.  Integration is being provided by the [MopaBootstrapBundle](https://github.com/phiamo/MopaBootstrapBundle)
Bootstrap has some decent documentation and [lesscss](http://lesscss.org/) also has good documentation. Read up on
those if you want to make major changes.  Otherwise you can simply open the file `src/Application/GlobalBundle/Resources/public/less/variables.less`
At the bottom of the file are the lines you should change.

```less
/* Custom variables */
    @badgeColor: gold;
    @badgeWidth: 75px;
    @badgeHeight: 75px;
    @badgeBorderRadius: 50px;
    @LightenBackground: 25%;
    
/* RHA Theme */
    @RhaBackgroundColor: #ffffff;
    @RhaGrey: #4a494a;
    @RhaRed: #B42E34;
    @RhaSuccess: #64ad45;
    @RhaInfo: #4ea8de;
    @RhaWarning: #f49b32;
    @RhaDanger: #ed1f24;
```

Replace the color hexes with your preferred colors.  When you are finsihed just dump the assets to see the changes

```shell
    php app/console assetic:dump --env=prod
```


