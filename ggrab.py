#!/usr/bin/env python3

#python test
import sys

from lib.google_search_results import GoogleSearchResults

params = {
    "q" : sys.argv[1],
    "num" : "1000",
    "location" : "Austin, Texas, United States",
    "hl" : "en",
    "gl" : "us",
    "google_domain" : "google.com",
    "api_key" : "",
}

query = GoogleSearchResults( params )
json_results = query.get_json()
#print( ">>>> {}".format(json_results['search_information']['query']) )
#print( ">>>> {}".format(json_results['search_information']['total_results']) )
#print( "" )

for r in json_results['organic_results']:
    #print( "{}. {}".format(r['position'],r['link']) )
    print( "{}".format(r['link']) )
