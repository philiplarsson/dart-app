-   [DartApp](#dartapp)
    -   [Generate documentation](#generate-documentation)
    -   [API](#api)
        -   [Available Routes](#available-routes)
        -   [Sorting and Pagination](#sorting-and-pagination)

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

Available endpoints can be seen below. A api-blueprint is being worked
on and can be seen in the documentation folder.

### Available Routes

#### Games

-   GET : api/v1/games

-   POST : api/v1/games

-   GET : api/v1/games/{id}

-   DELETE : api/v1/games/{id}

-   PATCH : api/v1/games/{id}

-   GET : api/v1/games/{id}/throws

#### GameTypes

-   POST : api/v1/gametypes

-   GET : api/v1/gametypes

-   PATCH : api/v1/gametypes/{id}

-   GET : api/v1/gametypes/{id}

-   DELETE : api/v1/gametypes/{id}

#### Throws

-   GET : api/v1/throws

-   POST : api/v1/throws

-   PATCH : api/v1/throws

-   GET : api/v1/throws/{id}

-   PATCH : api/v1/throws/{id}

-   DELETE : api/v1/throws/{id}

#### Users

-   POST : api/v1/users

-   GET : api/v1/users

-   DELETE : api/v1/users/{id}

-   PATCH : api/v1/users/{id}

-   GET : api/v1/users/{id}

-   GET : api/v1/users/{id}/throws

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
