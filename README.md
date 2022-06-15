# Contact app

Dockerized demo contact management application written in php 8.1 and symfony 6.1

## Run dockerized dev env
```
make system-init
```

Optionally to fill the database using fake data, you can run:
```
make fixtures
```

## Other functions

Format code using php-cs-fixer
```
make lintfix
```

PHPStan
```
make phpstan
```

Clear application cache
```
make clear-cache
```

Run database migrations
```
make migrate
```

Generate new migration
```
make migrations-diff
```
