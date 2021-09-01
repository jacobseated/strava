# Strava PHP code for Wordpress
This PHP code is fully OOP and follows basic design patterns to seperate design from logic,
and create code that is both simple to understand and easy to maintain. 

## Purpose
To engage with the Strava API and use Wordpress as a back-end for some things, this includes:

* Some of the layout and front-end stuff.
* User login-handling
* Possibly for certain Plugins

## Implementation 
**Note.** This will be updated as the ideas are implemented. This part is only relevant to future and existing developers.

If you are new to the code, this is what you should read before attempting to make changes to the system.


### Design and Layout
Ideally, certain important pages, should, for the most part, be created using HTML templates in **tpl/d/**
in order to best optimize for speed and SEO. But, since this may make it hard to load Plugins from Wordpress, we should probably limit this to certain important pages in the front-end.

The code uses its own database tables to store data obtained from Strava for increased flexibility.

### Routing
When creating a new route you got various options that you can configure. For example:
* The **Reqoest Type** that a given endpoint should allow E.g. *POST*, *GET*, *PUT*, *DELETE*
* Allowed **GET** and **POST** parameters (optional). Can be provided as an *array* in the *get_parms* and *post_parms* methods on a route object.

This system is seperate from Wordpress and allows us to easily add new features as needed in a clean way that does not interfere with Wordpress. 

#### URL Endpoints (routes)

The following URL endpoints are implemented in **index.php**, and just needs an improved design:

* **/authorize** — Obtains fresh *Access Tokens* from Strava's API
* **/deauthorize** — Invalidates obtained *Access Tokens* on the users request via Strava's API
* **/admin** — Shows an Admin page for the Strava related stuff that is clean, and seperate from the Wordpress back-end Stuff
* **/login** — Shows a login form, or accepts a login request (POST request) from the login form
* **/logout** — Logs the user out of the system via GET
* **/wp-admin** — Redirects a logged-in user to the Wordpress back-end. Users must be logged in as Admin to access the Wordpress back-end.

Each of these URL endpoints are implemented by creating a new **route** object that either calls a global function or instantiates an *app* class from **classes/_app/some_app_name/**
How to add new routes is self-explanatory if you are using a modern source code editor like *Visual Studio Code* with the *PHP Intelephense* Extension.

#### Apps (class handlers)
Apps are basically objects that handle request for URL endpoints, which are configured by adding routes.

An app in raw form is a class that extends **abstract_app_base.php** in order to make certain *properties*, *methods* and *objects* available for use inside each individual app.

All new apps should extend from **abstract_app_base.php**

When defining an app to be used, the **class_handler** method of a *route* object should be used.

#### Functions (function handlers)
The simplest handler possible is a function handler. It works by calling a global function when a specified URL endpoint is requested by a client.

To define a function handler and a function to be called, the **function_handler** method should be used. There is an example that is commented out for calling the build-in **phpinfo** function.

### The app_container object
This object contains certain Strava related stuff that should be available to all apps. The object is automatically included when instantiating an app class.

The **app_container** class extends from the **abstract_global_container** class.

The abstract class is core to the system, while app_container is more Strava-specific. If you have more stuff you need to make available for apps, add it to the app_container object.

### Directory structure
The project follows a basic directory structure:

* **includes/** — for things that should be globally available. Please avoid global functions. Rely on DI instead!
* **classes/** — contains various classes used to handle different things. E.g. A *http client* for cummunicating with Strava, and a *dev_log* for debugging purposes.
* **classes/_app/** — contains individual route handler classes.
* **classes/_containers/** — global container passed on to each app via Dependency Injection (DI).
* **../.credentials/** — for included files containing credentials for local database and the Strava *client_secret* and *client_id*
* **tpl/** — contains one directory per template, the *d* directory contains the default template.

### Current database tables (we may need more)
' strava_auth

### Dependencies
External dependencies should be kept to a minimum. The idea is to mostly rely on Wordpress build-in features, and create Plugins for the rest.

#### Wordpress
Wordpress implements a lot of functionality in the global space, which is bad, since we can not rely exclusivly on DI for objects; the solution I found is to simply check if the **wp-load.php** file has been included where these features are in use.

This is done inside the **app_container.php** file, because the class in this file is loaded automatically when individual apps are called 

#### External dependencies
Doing development some external code may be loaded, but this should generally be replaced with Wordpress build-in capabilities. Espicially with the Database stuff, as it will allow to handle character set issues centrally from Wordpress.

Code parts that rely on the external database client should be slightly re-written to use Wordpress database functions instead.
