extendedGitGraph
================

Displays a Commit Table for every of your github-years.
This is practically a copy of githubs Commit-Graph functionality. 
But with the extra feature of showing commits older than a year, from private repositories abd from other git remotes.

*See it live in action [here](https://www.mikescher.com/about)*

### How to use:

Create a new ExtendedGitGraph object

The constructor parameters are:

 * the path to the cache file
 * The output mode
    - STDOUT: Log to `print` and logfile
    - SESSION: Log session-variable and logfile (used for ajax calls)
    - LOGFILE: Only log to logfile
 * The logfile path. The 4 latest logs are kept and the placeholder {num} is used for different filenames

~~~php
include 'src/ExtendedGitGraph.php';

$v = new ExtendedGitGraph(__DIR__ . '/egh_cache.bin', ExtendedGitGraph::OUT_STDOUT, __DIR__ . '/../temp/egh_log{num}.log');
~~~

Next you need to add sources for us to search, currently supported are:

 * Github User accounts
 * Github Repositories
 * Gitea User accounts *(WIP)*
 * Gitea Repositories *(WIP)*

~~~php
$v->addRemote('github-user',       null, 'Mikescher', 'Mikescher');
$v->addRemote('github-user',       null, 'Mikescher', 'Blackforestbytes');
$v->addRemote('github-repository', null, 'Mikescher', 'Anastron/ColorRunner');
$v->addRemote('gitea-user',        null, 'Mikescher', 'Mikescher');
$v->addRemote('gitea-repository',  null, 'Mikescher', 'Benzin/MVU_API');
~~~

If you use github you need to specify an API token to get more than 60 API calls:
(get one from [Github -> Settings -> Developer Settings -> Personal access tokens](https://github.com/settings/tokens))

~~~php
$v->ConnectionGithub->setAPIToken('1234567890ABCDEF');
~~~

If you use gitea you need to specify the server url

~~~php
$v->ConnectionGitea->setURL('https://my-git-server.tld');
~~~

Now we generate the graphs, first call `init()`
~~~php
$v->init();
~~~

Then either query the data from our specified sources with `updateFromRemotes()` or load teh values from the last query from our specified cache file with `updateFromCache()`
~~~php
$v->updateFromRemotes();
//$v->updateFromCache();
~~~

Next call `generate()` to create HTML and get the snippets by calling `get()`.

~~~php
$v->setColorScheme('blue');
$v->generate();

foreach ($v->get() as $year => $html)
{
    file_put_contents(__DIR__ . '/../output/out_'.$year.'.html', $html);
}
~~~

You can set the used color scheme with `setColorScheme`, supported are:
 - custom
 - standard
 - modern
 - gray
 - red
 - blue
 - purple
 - orange
 - halloween

![](https://raw.githubusercontent.com/Mikescher/extendedGitGraph/master/README-DATA/preview_orange.png)  
![](https://raw.githubusercontent.com/Mikescher/extendedGitGraph/master/README-DATA/preview_purple.png)  
![](https://raw.githubusercontent.com/Mikescher/extendedGitGraph/master/README-DATA/preview_green.png)  
![](https://raw.githubusercontent.com/Mikescher/extendedGitGraph/master/README-DATA/preview_red.png)  

### Reload with Ajax:

The reloading can take a **long** time if you have a lot of commits and repositories.
Because of that you can also refresh via Ajax:

 - Call the file `ajax/ajaxReload.php?scheme=x` to start the reloading
 - Call the file `ajax/ajaxStatus.php` to get the current status (for displaying purposes)
 - Call the file `ajax/ajaxRedraw.php?scheme=x` to only redraw from cache

> **Attention:**  
> You need to create a file `ajaxSecret.php` that returns an ExtendedGitGraph object with your settings (remotes, repositories, tokens, etc).  
> Don't forget to set output mode to `ExtendedGitGraph::OUT_SESSION`

Below a crappy example implementation with jQuerys Ajax calls:

~~~html
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<script src="https://code.jquery.com/jquery-latest.min.js"></script>

		<link rel="stylesheet" type="text/css" href="/style.css">
		<script type="text/javascript" language="JavaScript">
			<?php include __DIR__ . '/../script.js'; ?>
		</script>

		<script type="text/javascript" language="JavaScript">
            function startAjaxRedraw() {
                $('#drawdiv').html("");

                var scheme = $("#select_scheme").val();

                val = setInterval(
                    function()
                    {
                        jQuery.ajax({
                            url:    '/ajax/ajaxStatus.php',
                            success: function(result)
                            {
                                var ajaxOutput = $('#ajaxOutput');

                                ajaxOutput.val(result);
                                ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
                            },
                            async:   true
                        });
                    }, 500);

                jQuery.ajax({
                    url:    '/ajax/ajaxRedraw.php?scheme='+scheme,
                    success: function(result)
                    {
                        clearInterval(val);
                        $('#drawdiv').html(result)
                    },
                    error: function(result)
                    {
                        clearInterval(val);

                        jQuery.ajax({
                            url:    '/ajax/ajaxStatus.php',
                            success: function(result)
                            {
                                var ajaxOutput = $('#ajaxOutput');

                                ajaxOutput.val(result + '\r\n' + 'AN ERROR OCCURED:' + '\r\n' + textStatus);
                                ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
                            },
                            async:   true
                        });
                    },
                    async:   true
                });
            }

			function startAjaxRefresh()
			{
                var scheme = $("#select_scheme").val();

				$('#ajaxOutput').val("");
                $('#drawdiv').html("");

				val = setInterval(
					function()
					{
						jQuery.ajax({
							url:    '/ajax/ajaxStatus.php',
							success: function(result)
							{
                                var ajaxOutput = $('#ajaxOutput');

                                ajaxOutput.val(result);
                                ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
							},
							async:   true
						});
					}, 500);

				jQuery.ajax({
					url:    '/ajax/ajaxReload.php?scheme='+scheme,
					success: function(result)
					{
						clearInterval(val);

						jQuery.ajax({
							url:    '/ajax/ajaxStatus.php',
							success: function(result)
							{
                                var ajaxOutput = $('#ajaxOutput');

                                ajaxOutput.val(result + '\r\n.');
                                ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
							},
							async:   true
						});

                        $('#drawdiv').html(result);
					},
					error: function( jqXHR, textStatus, errorThrown)
					{
						clearInterval(val);

						jQuery.ajax({
							url:    '/ajax/ajaxStatus.php',
							success: function(result)
							{
                                var ajaxOutput = $('#ajaxOutput');

								ajaxOutput.val(result + '\r\n' + 'AN ERROR OCCURED:' + '\r\n' + textStatus);
								ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
							},
							async:   true
						});
					},
					async:   true
				});

			}
		</script>

	</head>
	<body>
		<textarea style="width: 800px; height: 250px;" id="ajaxOutput" readonly="readonly" title="?"></textarea>

		<br>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:startAjaxRedraw()">[REDRAW]</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:startAjaxRefresh()">[REGENERATE]</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <select id="select_scheme">
            <option value="custom">custom</option>
            <option value="standard">standard</option>
            <option value="modern">modern</option>
            <option value="gray">gray</option>
            <option value="red">red</option>
            <option value="blue" selected="selected">blue</option>
            <option value="purple">purple</option>
            <option value="orange">orange</option>
            <option value="halloween">halloween</option>
        </select>

        <br />
        <br />
        <br />
        <br />

        <div id="drawdiv" >
			<?php
			foreach (glob(__DIR__ . '/../output/out_*.html') as $f)
			{
				echo file_get_contents($f);
				echo "\n\n\n<br/>\n\n\n";
			}
			?>
        </div>


    </body>
</html>
~~~
