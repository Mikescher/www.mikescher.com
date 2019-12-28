extendedGitGraph 2
==================

Displays a Commit Table for every of your github-years.
This is practically a copy of githubs commitGraph functionality. 
But with the extra feature of showing commits older than a year and from different sources.

*See it live in action [here](http://www.mikescher.de/about)*

![](https://raw.githubusercontent.com/Mikescher/extendedGitGraph/master/README-DATA/preview.png)

### How to use:

#### Overview

There are 3 primary methods to call on the `ExtendedGitGraph2` object:
 - `update()`: Query commit data from the respective git server APIs
 - `updateCache()`: Create the HTML code and cache it
 - `loadFromCache()`: Load the html code from cache and return it
 
A typical use case is to call `update()` and `updateCache()` eg once a day and call `loadFromCache()` every time you want to display the graph.

#### Cache

The commit data is cached in an sqlite database and the html code is cached in single html files.

#### Configuration

The `ExtendedGitGraph2` constructor wants a configuration array object.  
For an example look at the file `example/config.php`.

A few important configurations are:
 - The output methods (where the log is written to (stdout, session, file, ...))
 - The directory for the cache files
 - The identities (only commits from these email adresses are counted)
 - The remote sources
 
#### Remote sources

In the config array you have to supply one or more sources for commit data.
Currently two types are supported: `github` and (self-hosted) `gitea`

Additionally you can supply an array of excluded repositories.  
Also (for most remotes) you have to set some way of authentication (oauth, basic auth, etc)

#### Live status output

For a more interactive `update()` experience (it can take a few minutes depending how many repositories you have) you can set output_session to true and the output will be written to a session variable.
Then you can repeatedly query the session to get the current stdout.  
For a (quick and dirty) written example see `example/index.php`.

#### CSS, javascript and themes

You need to include the supplied script.js and style.css (script.js only if you want to have the tooltip).  
Also you can change the theme by editing the style.css and uncommenting the theme definitions.

There are a few predefined themes included:
 - custom
 - standard
 - modern
 - gray
 - red
 - blue
 - purple
 - orange
 - halloween

#### Contribute

yes, please.