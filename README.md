# UrlGrabber
PHP tool to grab urls of a specific site from different sources.  
Note that this is an automated tool, manual check is still required.  

```
Usage: php urlgrabber.php [OPTIONS] --target <target>

Options:
	-h, --help	print this help
	--malicious	enable malicious search, urls (with parameters) containing "&" or "?"
	--no-assets	exclude assets
	--source	source to use, default=all
	--target	targeted website
	--tor	use tor (must be installed and enabled)
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
