# appsconcept

This repository contains a Symfony API for the FizzBuzz math/word game.

The API endpoints are served by the controllers via a CQRS design pattern (src/Query, src/QueryHandler).
Stats are saved in the DB and updated by an Event Listener (src/Event, src/EventListener), which could easily be converted into an async operation with Symfony Messenger.

## Steps to boot up the project
* As a pre-condition, Docker should be installed in your machine
* Open a terminal and navigate to the project root directory
* Run ```make init```

This should create all the infrastructure and open a functional API docs page in a browser tab.


## Tests
* ```make tests```

This runs PHP Codesniffer for code standards, PHPStan for static analysis and PHPUnit for unit tests.