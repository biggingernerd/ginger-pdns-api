ginger-pdns-api
===============

Awesome Ginger PowerDNS Rest API


How To Install
--------------

- 1: Put in apache, rewrite all to /index.php (you could also use the contents of htaccess.txt)
- 2: Put database credentials to powerdns database in config/database.php (copy file config/database.php.dist)
- 3: Go to resource by getting /domain (For instance).
- 4: Receive the (not so) awesome JSON
- 5: Have a beer and wait until more functionality is written (though it would be even more awesome when you'd have a beer and write more functionality)


YEAH!

Resources
---------

- domain
- record
- supermaster

GET /domain/ - get all domains
GET /domain/id/1 - get domain with ID = 1
POST /domain/ - create new domain
DELETE /domain/id/1	- delete domain with ID = 1

GET /record/ - get all records
GET /record/id/1 - get record with ID = 1
POST /record/ - create new record
DELETE /record/id/1	- delete record with ID = 1





Filter
------

You can filter the resultset by adding get parameters to the url or to add them key value paired to the path.
This means that /domain/?id=1 is the same as /domain/id/1 and /record/type/a/domain_id/141 is the same as /record?type=a&domain_id=141

