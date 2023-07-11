# Sensor API

## Get started

### Development environment

Install [DDEV](https://ddev.readthedocs.io/en/stable/)

Then you can start your environment:

```shell
ddev start
```

It will output your project URL.

If you need to get more information run:

```shell
ddev status
```

You can access your container via SSH:

```shell
ddev ssh
```

### Install dependencies

In your DDEV container run [composer](https://getcomposer.org)

```shell
composer install
```

### Database migration

In your DDEV container run [phinx](https://phinx.org)

```shell
phinx migrate
```

## API reference

### API #1

API saves received information to the implemented storage and expects
a JSON object in a POST request body with the following structure:

```
POST /api/push
{
    "reading": {
        "sensor_uuid": "unique uuid of sensor",
        "temperature": "decimal format, xxx.xx, in celsius"
    }
}
```

### API #2

This API is a sensor API that simulates information read from a censor.
Sensor  information is expected to be random. Endpoint expects a GET request:

```
GET /sensor/read/%sensor_ip%
```

Return is a CSV-string:

```
reading_id, <temperature in Celsius in format xxx.xx decimal>
```

reading_id is a sequence number, which increases each time when sensor reads temperature.

## Contributing

You can add actions in `src/Actions` and define them in `app/routes.php`.

Configure dependencies in `app/dependencies.php`.

More about [Slim](https://www.slimframework.com/docs/v4/).

### Todo

- add configuration via ENV variables
- add services and use them in actions (get rid of plain SQL in actions)
- add ORM, entities
- make advanced error handling
