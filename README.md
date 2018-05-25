-   [DartApp](#dartapp)
    -   [Generate documentation](#generate-documentation)
    -   [API](#api)
        -   [Available Routes](#available-routes)
        -   [Sorting and Pagination](#sorting-and-pagination)

DartApp
=======

Generate documentation
----------------------

``` {.shell}
dartapp/documentation $ aglio -i doc.apib -o ../public/documentation.html
```

Deploying to Heroku
-------------------

The following env variables need to be set:

- APP_KEY (can be set by using `heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)` )
- LOG_CHANNEL (which probably should be `errorlog`)
- DB_CONNECTION
- DB_HOST
- DB_USERNAME
- DB_PASSWORD
- DB_PORT
- DB_DATABASE

Then create tables and optimize autoloaders by first running a shell environment
on the app `heroku run bash`.

Optimize autoloader: `composer install --optimize-autoloader`.
Optimize configuration loading: `php artisan config:cache`.
Since we are using a closure to present the documentation, we can't optimize the
route loading, but if you remove the documentation in `routes/web.php` you could run: `php artisan route:cache` to do so.

Running all migrations: `php artisan migrate`. 

Then you should run atleast 3 seeders:
- `php artisan db:seed --class=MultiplierSeeder` to seed the `multipliers` table
  with the standard 1,2 and 3 multiplier value.
- `php artisan db:seed --class=PointSeeder` to seed the `points` table with all possible points.
- `php artisan db:seed --class=UserTypeSeeder` to seed `user_types` table with
  admin and users.

If you want to create dummy users and dummy data you can run all seeders with:
- `php artisan db:seed`.

Next you should create a user. Some routes need admin users so below we will
create one admin user and one "regular" user.

`php artisan tinker` to get a php shell.

Fetch id for users and admin:
```
$userTypeId = DB::table('user_types')->where('type', 'user')->first()->id
$adminTypeId = DB::table('user_types')->where('type', 'admin')->first()->id;
```

Then to create a regular user:
```
$bob = new User([
... 'name' => 'Bob Bobson',
... 'username' => 'bobb',
... 'email' => 'bob@example.com',
... 'type_id' => $userTypeId,
... 'password' => bcrypt('pw')
... ]);
=> App\User {#817
     name: "Bob Bobson",
     username: "bobb",
     email: "bob@example.com",
     type_id: 1,
   }
>>> $bob->save();
=> true
```

And for admin user:
```
$alice = new User([
... 'name' => 'Alice W',
... 'username' => 'alicew',
... 'email' => 'alice@example.com',
... 'type_id' => $adminTypeId,
... 'password' => bcrypt('pw')
... ]);
=> App\User {#802
     name: "Alice W",
     username: "alicew",
     email: "alice@example.com",
     type_id: 2,
   }
>>> $alice->save();
=> true
```

API
---

DartApp uses a RESTful API. 

DartApp uses 4 main endpoints.

-   **Cast**: This is a throw made. A cast is related to a game (which
    the throw belongs to) and a user (who threw the dart).
-   **GameType**: Different gametypes such as \"20 to 15\" or \"201\".
-   **Game**: A single match. A game has a gametype.
-   **User**: A person who participates in a game and throw darts.

When making requests, the following headers should be set:

-   Accept: application/json
-   Content-Type: application/json

Available endpoints can be seen in the api-blueprint in the 
documentation folder. If app is deplayed they documentation can be generated and 
seen can bee seen at the main page (/).


### Sorting and Pagination

1.  Sort Response

    For some routes the order can be sorted in reverse order by using a
    query parameter like so:

    -   GET `http://localhost:8000/api/v1/throws?sort_by=asc`
    -   GET `http://localhost:8000/api/v1/games?sort_by=asc`

    If no query parameter is specified the result is ordered in
    descending order (latest first).

2.  Pagination

    Pagination is used for enpoints where the data is *large*. Add query
    parameter `page` like so:

    -   GET `http://localhost:8000/api/v1/throws?page=2`
