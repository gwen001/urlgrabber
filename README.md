# UrlGrabber
PHP tool to grab urls of a specific site from different sources.  
Note that this is an automated tool, manual check is still required.  

```
Usage: php urlgrabber.php [OPTIONS] --target <target>

Options:
	--dork		specify the Google dork used by Lynx and INURLBR, default='site:<source>'
	-h, --help	print this help
	--https		force https
	--no-assets	exclude assets
	--only-params	exclude urls without any parameter
	--source	source to use, default=all
	--target	targeted website
	--tor		use tor (torsocks required)
	--verbose	0=all, 1=remove extra text

Examples:
	php urlgrabber.php --target <www.example.com>
	php urlgrabber.php --target <www.example.com> --source 1,2,95
	php urlgrabber.php --target <www.example.com> --malicious --no-assets
	
Available sources are:
	1. Google via Lynx
	2. Google via INURLBR
	3x. Wget, x=depth, default=1
	4. Waybackurls
	5. Google via custom grabber
	6. Common Crawl
	9x. Loop, will check the source code of urls found to try to get new urls, x=how many loops, default=1 (not implemented yet)
```

I don't believe in license.  
You can do want you want with this program.  
