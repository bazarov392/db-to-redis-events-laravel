# DB to Redis Events Laravel
<p>Events about data changes from the database to Redis.</p>

* At the moment, it is only compatible with MySQL and Laravel because it uses models from Laravel.

## Installion 

Install package 
```bash
composer require bazarov392/db-to-redis-events-laravel
```

## Use

```php
// app/Providers/AppServiceProvider.php
use Bazarov392\RedisEventsFromDB;

public function boot(): void
{
    RedisEventsFromDB::init();
    // ...
}
```

## Docs

Format message
```text
db_event.{tableName}.{typeEvent}.{idRow}
```

* <b>tableName</b> - Table name
* <b>typeEvent</b> - Type event ( <b>created</b> | <b>updated</b> | <b>deleted</b> )
* <b>idRow</b> - If the column has a primary key, it will be listed here. If not, it will not be specified, but the JSON of the model will be in the body of the event.
