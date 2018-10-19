# Lite (very simple) messenger app prototype.
Basic messenger prototype based on REST api + MySQL, using symfony framework.

_You need to write a simple messenger REST service.
UI is not necessary._

#Basic service requirements:
- REST API only
- symfony 3.4
- mysql (database structure at your discretion)

#Requirements for functionality:
- a list of methods that must be implemented:
- - get a list of all conversations
- - get a list of messages of a specific conversation
- - to write a message
- - delete dialogue
- - delete all dialogs
- cover at least one REST method (API endpoint) with tests

# Deployment

1. clone project
2. ```docker-compose up -d --build```
3. Add ``` messenger.dev 0.0.0.0 ``` to ```/etc/hosts```
4. ```docker exec -it messenger_app composer install```

5.Update DB
```
docker exec -it messenger_app php bin/console doctrine:database:create --env=dev --if-not-exists
docker exec -it messenger_app php bin/console doctrine:schema:update --env=dev --force
docker exec -it messenger_app php bin/console doctrine:migrations:migrate --env=dev
```


6.Start test: 
``` docker exec -it messenger_app /var/www/messenger/vendor/bin/phpunit --configuration /var/www/messenger/phpunit.xml.dist ```
