## Introduction

This is a (cross platform, standalone) web app to display videos downloaded by [youtube-dl](https://youtube-dl.org/) (or similiar tools) and view them inside your browser in a nice (youtube-like) UI.

## Usage / QuickStart

#### - Local Usage

The easiest way to use is to simply drop the binary in the directory with the video files, run it and open the displayed URL in your browser.  
For a bit more customization you can create a `.bat` or `.sh` wrapper to run it with a few parameter

~~~batch
REM Example:
REM (remove comments before copying)

youtube-dl-viewer.exe                                ^
  --cache="C:\Users\me\AppData\Local\Tempytdl_cache" ^  # specify cache directory for generated thumbnails
  --videomode=6                                      ^  # default to local vlc protocol links for playback
  --thumbnailmode=2                                  ^  # default to grid 
  --open-browser                                        # autom. open browser after startup
~~~

#### - Server Usage

Another use case is to have your video files synchronized to a server and host a permanent instance of youtube-dl-viewer there.  
Then you can either access it directly via the specified port or use [nginx/apache as a reverse proxy](https://httpd.apache.org/docs/2.4/howto/reverse_proxy.html)

~~~bash
#!/bin/bash

DOTNET_BUNDLE_EXTRACT_BASE_DIR=/home/web_aspnet/dot_net_cache/
export DOTNET_BUNDLE_EXTRACT_BASE_DIR

./youtube-dl-viewer --port=9876                                                              \
                    --cache="/media/youtube-dl-viewer_cache/"                                \
                    --display=0 --order=0 --width=1 --thumbnailmode=1 --videomode=3          \
                    --path="/media/nextcloud/data/Mikescher/files/Videos/YoutubePlaylist1"   \
                    --path="/media/nextcloud/data/Mikescher/files/Videos/YoutubePlaylist2"   \
                    --path="/media/filecloud/data/Mikescher/files/Videos/YoutubePlaylist3"
~~~

~~~
<VirtualHost *:80>
        ServerName  example.com

        ProxyPreserveHost On
        ProxyRequests off
        ProxyPass        / http://127.0.0.1:9876/
        ProxyPassReverse / http://127.0.0.1:9876/

        ErrorLog /var/log/apache2/error_youtube-dl-viewer.log
        LogLevel warn
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
~~~

For synchronization you can use for example nextcloud, but every solution where youtube-dl-viewer can access the raw files on your filesystem works.


#### - youtube-dl

You can use any youtube-dl parameters as you want.  
youtube-dl-viewer will use any data it has, the only necessary file is the actual video. But it will also use and display available metadata (aka `*.info.json`, `*.description` and thumbnails).  

My youtube-dl parameters are these:
~~~
youtube-dl 

--download-archive "{archive_location}"
--output "{ouput_location}\%%(playlist_index)s - %%(title)s.%%(ext)s"

--format "bestvideo+bestaudio/best"

--no-overwrites
--restrict-filenames
--ignore-errors 

--write-description
--write-info-json
--write-annotations
--write-thumbnail
--all-subs

--recode-video mkv


"https://www.youtube.com/{playlist_url}"
~~~

If you start backup from scratch I would recommend to use `--recode-video webm`. webm (or mp4) is by default a format that can be streamed to your browser, this way you can easily watch the directly in your browser.  
Otherwise you can either use the `transcoded webm stream` option, where the video is live transcoded via ffmpeg (needs to be installed), or the VLC protocol link where the file is streamed to your VLC media player


#### - Playback options

youtube-dl-viewer supports playing the videos by clicking on them, there are multiple modes for this available:

 - **Disabled:**  
   Does not play the video. Duh.
 - **Seekable raw file:**  
   Try to play the video in a native browser <media> element. This will only work if the video is already in a supported streamable format, which is (currently) only webm and mp4 (and only mp4's generated with the correct parameters). If the video format is not supported you will get an error message in your browser
 - **Raw file:**  
   This is mostly the same as **Seekable raw file**, with the same limitations. But this one also does not support HTTP range requests, which means you can't easily skip forward in the video.
 - **Transcoded webm stream:**  
   This mode uses a [ffmpeg](https://ffmpeg.org/) to transcode the video file to webm file and stream it to the user.  
   A working ffmpeg installation is required because youtube-dl-viewer will simply call the ffmpeg command. If you do not have (and do not want) a ffmpeg installation you can start youtube-dl-viewer with the command `--no-ffmpeg` to disable all ffmpeg dependent functionality.  
   If you don't want to use the default ffmpeg of your system you can specify an executable with the arguments `--exec-ffmpeg` and `--exec-ffprobe` 
   You can tweak the ffmpeg parameters with the parameter `--webm-convert-params`.  
   Depending on the video, the parameter and you machine ffmpeg may not be able to encode the video fast enough for a smooth playback. To fix this prolem (at least a bit) you can supply youtube-dl-viewer with a `--cache` path where past converted videos will be remembered so that the next time the converted artifacts will be re-used.  
   Also you can limit the maximum amount of parallel ffmpeg conversion jobs with the `--max-parallel-convert` parameter.
 - **Download file:**  
  Simply prompt the user to download the video file.
 - **VLC protocol link (stream):**  
  Opens a `vlc://...` link to the video file. This is useful if your videos are in a format that's generally streamable but simply not supported by your browser (a common example is mkv).  
  Unfortunately vlc is not a protocol that's supported by default so you have to manually register it, an implementation/installation can be found at [stefansundin/vlc-protocol](https://github.com/stefansundin/vlc-protocol/).  
  This option depends on a working `vlc://` protocol and the fact that the video format is supported by [VLC](https://www.videolan.org/vlc/).
 - **VLC protocol link (local):**  
  This is mostly the same as **VLC protocol link (stream)** but it adds the local file path to your VLC playlist and not the video URL.  
  This is preferable if youtube-dl-viewer is running on your machine, because then the VLC Player doesn't have to yo through web requests to get the file and can simply read it from your hard drive, but of course this only works if VLC can access the original video file path (eg if its not running on a server)

&nbsp;

&nbsp;

> **[!] See github README for a more in-depth manual**  
> &nbsp;  
> https://github.com/Mikescher/youtube-dl-viewer/blob/master/README.md
> &nbsp;  
> &nbsp;  