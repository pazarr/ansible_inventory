#!/usr/bin/python
import urllib2, sys
try:
 sys.argv[1]
except:
 print "Missing parameter"
 sys.exit(1)
if sys.argv[1] == "--list":
 response = urllib2.urlopen('http://localhost/inventory.php?q=list')
 html = response.read()
 print html
 sys.exit()
elif sys.argv[1] == "--host":
 try:
  sys.argv[2]
 except:
  print "Missing parameter"
  sys.exit(1)
 response = urllib2.urlopen('http://localhost/inventory.php?q=host&hostname=' + sys.argv[2])
 html = response.read()
 print html
 sys.exit(0)
