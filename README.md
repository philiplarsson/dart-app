DartApp
=======

Documentation is at: <https://secure-scrubland-72615.herokuapp.com>.

Request example:
<https://secure-scrubland-72615.herokuapp.com/api/v1/games>.

Generate documentation
----------------------

``` {.shell}

dartapp/documentation $ aglio -i doc.apib -o ../public/documentation.html

```

API
---

DartApp uses a RESTful API. The API is Work In Progress.

DartApp uses 4 main endpoints.

-   **Cast**: This is a throw made. A cast is related to a game (which
    the throw belongs to) and a user (who throw the dart).
-   **GameType**: Different gametypes such as \"20 to 15\" or \"201\".
-   **Game**: A single match. A game has a gametype.
-   **User**: A person who participates in a game and throw darts.

When making requests, the following headers should be set:

-   Accept: application/json
-   Content-Type: application/json

API description can be seen below, but is being replaced by a
api-blueprint documentation.

### Available Routes

  Method   URI                        Name   Action                                                   Middleware
  -------- -------------------------- ------ -------------------------------------------------------- ------------
  GET      /                                 Closure                                                  web
  GET      api/v1/games                      App\Http\Controllers\API\GameController@index            api
  POST     api/v1/games                      App\Http\Controllers\API\GameController@store            api
  GET      api/v1/games/{id}                 App\Http\Controllers\API\GameController@show             api
  DELETE   api/v1/games/{id}                 App\Http\Controllers\API\GameController@destroy          api
  PATCH    api/v1/games/{id}                 App\Http\Controllers\API\GameController@update           api
  GET      api/v1/games/{id}/throws          App\Http\Controllers\API\GameController@throws           api
  POST     api/v1/gametypes                  App\Http\Controllers\API\GameTypeController@store        api
  GET      api/v1/gametypes                  App\Http\Controllers\API\GameTypeController@index        api
  PATCH    api/v1/gametypes/{id}             App\Http\Controllers\API\GameTypeController@update       api
  GET      api/v1/gametypes/{id}             App\Http\Controllers\API\GameTypeController@show         api
  DELETE   api/v1/gametypes/{id}             App\Http\Controllers\API\GameTypeController@destroy      api
  GET      api/v1/throws                     App\Http\Controllers\API\CastController@index            api
  POST     api/v1/throws                     App\Http\Controllers\API\CastController@store            api
  PATCH    api/v1/throws                     App\Http\Controllers\API\CastController@updateMultiple   api
  GET      api/v1/throws/{id}                App\Http\Controllers\API\CastController@show             api
  PATCH    api/v1/throws/{id}                App\Http\Controllers\API\CastController@update           api
  DELETE   api/v1/throws/{id}                App\Http\Controllers\API\CastController@destroy          api
  POST     api/v1/users                      App\Http\Controllers\API\UserController@store            api
  GET      api/v1/users                      App\Http\Controllers\API\UserController@index            api
  DELETE   api/v1/users/{id}                 App\Http\Controllers\API\UserController@destroy          api
  PATCH    api/v1/users/{id}                 App\Http\Controllers\API\UserController@update           api
  GET      api/v1/users/{id}                 App\Http\Controllers\API\UserController@show             api
  GET      api/v1/users/{id}/throws          App\Http\Controllers\API\UserController@throws           api

### API Description

1.  Throws

    1.  Create throws: POST api/v1/throws

        **Request** POST api/v1/throws with body:

        ``` {.javascript org-language="js"}
        {
          "user_id": "1",
          "game_id": "20",
          "pie_value": "1",
          "multiplier": "1"
        }
        ```

        or to create multiple:

        ``` {.javascript org-language="js"}
        [
        {
          "user_id": "1",
          "game_id": "20",
          "pie_value": "1",
          "multiplier": "1"
        },
        {
          "user_id": "1",
          "game_id": "20",
          "pie_value": "2",
          "multiplier": "1"
        },
        {
          "user_id": "1",
          "game_id": "20",
          "pie_value": "25",
          "multiplier": "1"
        },
        {
          "user_id": "3",
          "game_id": "20",
          "pie_value": "50",
          "multiplier": "1"
        }
        ]
        ```

        **Response example**:

        ``` {.javascript org-language="js"}
        {
          "data": [
            {
              "id": 32,
              "pie_value": 1,
              "multiplier": 1,
              "created_at": "2018-03-14 15:50:08",
              "created_at_human": "1 second ago"
            },
            {
              "id": 33,
              "pie_value": 2,
              "multiplier": 1,
              "created_at": "2018-03-14 15:50:08",
              "created_at_human": "1 second ago"
            },
            {
              "id": 34,
              "pie_value": 25,
              "multiplier": 1,
              "created_at": "2018-03-14 15:50:08",
              "created_at_human": "1 second ago"
            },
            {
              "id": 35,
              "pie_value": 50,
              "multiplier": 1,
              "created_at": "2018-03-14 15:50:08",
              "created_at_human": "1 second ago"
            }
          ]
        }
        ```

    2.  Fetch throws: GET api/v1/throws

        **Request**: GET api/v1/throws

        **Response**:

        ``` {.javascript org-language="js"}
         {
          "data": [
            {
              "id": 1,
              "pie_value": 3,
              "multiplier": 2,
              "created_at": "2018-03-14 15:46:43",
              "created_at_human": "3 seconds ago",
              "user": {
                "data": {
                  "id": 3,
                  "name": "Mac Klein",
                  "username": "ali.brakus",
                  "avatar": "https:\/\/www.gravatar.com\/avatar\/cea373ce39b8332ce5db287c3aa27b5a?s=80&d=retro",
                  "account_type": "admin"
                }
              },
              "game": {
                "data": {
                  "id": 11,
                  "created_at": "2018-03-14 15:46:43",
                  "created_at_human": "3 seconds ago",
                  "gametype": {
                    "data": {
                      "id": 1,
                      "name": "20 to 15",
                      "description": "Mollitia est voluptatem animi tempore."
                    }
                  }
                }
              }
            },
            {
              "id": 17,
              "pie_value": 10,
              "multiplier": 3,
              "created_at": "2018-03-14 15:46:43",
              "created_at_human": "3 seconds ago",
              "user": {
                "data": {
                  "id": 7,
                  "name": "Jena Lueilwitz",
                  "username": "vandervort.tyreek",
                  "avatar": "https:\/\/www.gravatar.com\/avatar\/aec5784d02b0829772f35bdb452b4a95?s=80&d=retro",
                  "account_type": "admin"
                }
              },
              "game": {
                "data": {
                  "id": 4,
                  "created_at": "2018-03-14 15:46:43",
                  "created_at_human": "3 seconds ago",
                  "gametype": {
                    "data": {
                      "id": 1,
                      "name": "20 to 15",
                      "description": "Mollitia est voluptatem animi tempore."
                    }
                  }
                }
              }
            }
         ],
          "meta": {
            "pagination": {
              "total": 2,
              "count": 2,
              "per_page": 50,
              "current_page": 1,
              "total_pages": 1,
              "links": []
            }
          }
        }

        ```

    3.  Update throws: PATCH api/v1/throws

        To update a single throw:

        **Request**: api/v1/throws/{id}

        with body

        ``` {.javascript org-language="js"}
        {
          "user_id": "3",
          "game_id": "2",
          "pie_value": "50",
          "multiplier": "1"
        }
        ```

        To update multiple, use

        **Request**: api/v1/throws

        with those properties you wish to update in the body.
        `throws_id` is required.

        ``` {.javascript org-language="js"}
        [
        {
            "throws_id": "149",
            "user_id": 2
        },
        {
            "throws_id": "148",
          "user_id": "3"
        }
        ]
        ```

        **Response example**:

        ``` {.javascript org-language="js"}
        {
          "data": [
            {
              "id": 149,
              "pie_value": 1,
              "multiplier": 1,
              "created_at": "2018-03-14 14:54:26",
              "created_at_human": "40 minutes ago"
            },
            {
              "id": 148,
              "pie_value": 1,
              "multiplier": 1,
              "created_at": "2018-03-14 14:54:26",
              "created_at_human": "40 minutes ago"
            }
          ]
        }
        ```

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
