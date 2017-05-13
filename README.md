# UrlGrabber
PHP tool to grab urls of a specific site from different sources.  
Note that this is an automated tool, manual check is still required.  

```
Usage: php urlgrabber.php [OPTIONS] --target <target>

Options:
	-h, --help	print this help
	--target	targeted website
	--source	source to use, default=all
	-verbose	verbosity level:
			0=everything (default)
			1=XSS and errors
			2=XSS only

Examples:
	php urlgrabber.php --target <www.example.com>
	php urlgrabber.php --target <www.example.com> --source 1,2
	
Available sources are:
	1. Google via Lynx
	2. Google via INURLBR
	3. Wget
```

I don't believe in license.  
You can do want you want with this program.  
