[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

# service-library-catalog-php

## Assignment

Build a tiny REST API and use this to build 2 resources.
Books and Authors.

GET: /book/:id
Expect a book with the author

GET: /author/:id
Expect an author with all his books

POST: /author/
Create an author

POST: /book
Create a book and add an author to it.

## Ideas, developing

 * **Repositories**: Implements storing in PDO (Mysql) and caching in Redis, configurable with envs (see: docker-compose.override.yml). Tests use Sqlite and redis-mock. The idea is App caches Book with/without its Author and Author with/without his/her books. When client adds new book, Author's cache invalidates.
 * **Catalogue**: the Service that manages all these Repositories. 
 * [Authentication](#Authentication): App has Auth interface and implementation of supporting Bearer Auth. Other implementations can be added also.
 * **Authorization**: Interface and simple implementation of ACL: guests can read, users can add Books (but not Authors), admin can add Books and Authors. 
 * [Api endpoints](#Endpoints): Specs for HTTP endpoints.
 * **Transformers and Hydrators**: App has its own "Serializer" which helps encode/decode entities for storing in some repository (document-oriented). Basic transformers for representing data in HTTP-response.  
 * **Controllers**: V1 implements basic json REST, we can add more versions to support other protocols.


## Install

To let dockerization's network work on the local machine plz add to your /etc/hosts:

``` bash
    127.0.0.1 host.docker.internal
```

And then:

``` bash
    ### Download
    composer create-project alex-foleon/service-library-catalog-php:^0.1 catalogue --prefer-dist --ignore-platform-reqs
    cd catalogue
    ### Prepare default dockerization
    cp docker-compose.override.yml.dist docker-compose.override.yml
    docker-compose up -d
    
    ### Create database
    docker exec -it rds-library bash -c "mysql -uroot -pmy-secret-pw -e \"create database catalogue CHARACTER SET utf8 COLLATE utf8_general_ci\""
    ### Start migrations
    docker exec -it service-catalogue-php bash -c "./scripts/migrate.sh"
    ### Check system works
    curl -i http://127.0.0.1:8080/api/v1/healthcheck
```

After that App should work via http://127.0.0.1:8080

## Testing

``` bash
    docker exec -it service-catalogue-php bash -c "composer test"
```

Test coverage is more than [90%][link-scrutinizer]. More tests should be implemented, but it takes time. Code quality is [~9.8][link-code-quality].

## Authentication

App has simple Auth-service. Client should provide base64 encoded token to "Authorization" HTTP-header. Token should have the next json-structure:
```json
{
  "secret": "some-secret",
  "payload": "roleId:clientId"
}
``` 

For example:
```json
{"secret": "some-secret", "payload": "user:184"}
``` 

There are 3 roles in the App: **guest**, **user** and **admin**. No matter what ID is used as App doesn't has users repository.

You can use next encoded tokens which work for default env:

* Guest: eyJzZWNyZXQiOiJzdXBlcl9kdXBlcl9zZWN1cml0eSIsInBheWxvYWQiOiJndWVzdDozIn0=
* User: eyJzZWNyZXQiOiJzdXBlcl9kdXBlcl9zZWN1cml0eSIsInBheWxvYWQiOiJ1c2VyOjQifQ==
* Admin: eyJzZWNyZXQiOiJzdXBlcl9kdXBlcl9zZWN1cml0eSIsInBheWxvYWQiOiJhZG1pbjo1In0=
* Alien: eyJzZWNyZXQiOiJzdXBlcl9kdXBlcl9zZWN1cml0eSIsInBheWxvYWQiOiJhbGllbjo2In0= (should be denied)

## Endpoints

1. Create the Author.

**POST** /author
```json
{
    "name": "Charles Dickens",
    "birthdate": "1812-02-07",
    "deathdate": "1870-06-09",
    "biography": "Born in Portsmouth, Dickens left school to work in a factory when his father was incarcerated in a debtors' prison. Despite his lack of formal education, he edited a weekly journal for 20 years, wrote 15 novels, five novellas, hundreds of short stories and non-fiction articles, lectured and performed readings extensively, was an indefatigable letter writer, and campaigned vigorously for children's rights, education, and other social reforms. ",
    "summary": "Charles John Huffam Dickens FRSA (/ˈdɪkɪnz/; 7 February 1812 – 9 June 1870) was an English writer and social critic. He created some of the world's best-known fictional characters and is regarded by many as the greatest novelist of the Victorian era.[1] His works enjoyed unprecedented popularity during his lifetime, and by the 20th century, critics and scholars had recognised him as a literary genius. His novels and short stories are still widely read today."
}
```

Response: [200]
```json
{
    "id": "1",
    "name": "Charles Dickens",
    "birthdate": "1812-02-07",
    "deathdate": "1870-06-09",
    "biography": "Born in Portsmouth, Dickens left school to work in a factory when his father was incarcerated in a debtors' prison. Despite his lack of formal education, he edited a weekly journal for 20 years, wrote 15 novels, five novellas, hundreds of short stories and non-fiction articles, lectured and performed readings extensively, was an indefatigable letter writer, and campaigned vigorously for children's rights, education, and other social reforms. ",
    "summary": "Charles John Huffam Dickens FRSA (/ˈdɪkɪnz/; 7 February 1812 – 9 June 1870) was an English writer and social critic. He created some of the world's best-known fictional characters and is regarded by many as the greatest novelist of the Victorian era.[1] His works enjoyed unprecedented popularity during his lifetime, and by the 20th century, critics and scholars had recognised him as a literary genius. His novels and short stories are still widely read today."
}
```

2. Create the book.

**POST** /book
```json
{
    "title": "Dombey and Son",
    "summary": "Dombey and Son is a novel by English author Charles Dickens. It follows the fortunes of a shipping firm owner, who is frustrated at the lack of a son to follow him in his footsteps; he initially rejects his daughter’s love before eventually becoming reconciled with her before his death. ",
    "authorId": 1
}
```

Response: [200]
```json
{
    "id": "1",
    "title": "Dombey and Son",
    "summary": "Dombey and Son is a novel by English author Charles Dickens. It follows the fortunes of a shipping firm owner, who is frustrated at the lack of a son to follow him in his footsteps; he initially rejects his daughter’s love before eventually becoming reconciled with her before his death. "
}
```

3. Read the author.

**GET** /author/ID

Response: [200]
```json
{
    "id": "1",
    "name": "Charles Dickens",
    "birthdate": "1812-02-07",
    "deathdate": "1870-06-09",
    "biography": "Born in Portsmouth, Dickens left school to work in a factory when his father was incarcerated in a debtors' prison. Despite his lack of formal education, he edited a weekly journal for 20 years, wrote 15 novels, five novellas, hundreds of short stories and non-fiction articles, lectured and performed readings extensively, was an indefatigable letter writer, and campaigned vigorously for children's rights, education, and other social reforms. ",
    "summary": "Charles John Huffam Dickens FRSA (/ˈdɪkɪnz/; 7 February 1812 – 9 June 1870) was an English writer and social critic. He created some of the world's best-known fictional characters and is regarded by many as the greatest novelist of the Victorian era.[1] His works enjoyed unprecedented popularity during his lifetime, and by the 20th century, critics and scholars had recognised him as a literary genius. His novels and short stories are still widely read today.",
    "books": [
        {
            "id": "1",
            "title": "Dombey and Son",
            "summary": "Dombey and Son is a novel by English author Charles Dickens. It follows the fortunes of a shipping firm owner, who is frustrated at the lack of a son to follow him in his footsteps; he initially rejects his daughter’s love before eventually becoming reconciled with her before his death. "
        }
    ]
}
```

4. Read the book.

**GET** /book/ID

Response: [200]
```json
{
    "id": "1",
    "title": "Dombey and Son",
    "summary": "Dombey and Son is a novel by English author Charles Dickens. It follows the fortunes of a shipping firm owner, who is frustrated at the lack of a son to follow him in his footsteps; he initially rejects his daughter’s love before eventually becoming reconciled with her before his death. ",
    "author": {
        "id": "1",
        "name": "Charles Dickens",
        "birthdate": "1812-02-07",
        "deathdate": "1870-06-09",
        "biography": "Born in Portsmouth, Dickens left school to work in a factory when his father was incarcerated in a debtors' prison. Despite his lack of formal education, he edited a weekly journal for 20 years, wrote 15 novels, five novellas, hundreds of short stories and non-fiction articles, lectured and performed readings extensively, was an indefatigable letter writer, and campaigned vigorously for children's rights, education, and other social reforms. ",
        "summary": "Charles John Huffam Dickens FRSA (/ˈdɪkɪnz/; 7 February 1812 – 9 June 1870) was an English writer and social critic. He created some of the world's best-known fictional characters and is regarded by many as the greatest novelist of the Victorian era.[1] His works enjoyed unprecedented popularity during his lifetime, and by the 20th century, critics and scholars had recognised him as a literary genius. His novels and short stories are still widely read today."
    }
}
```

[ico-version]: https://img.shields.io/packagist/v/alex-foleon/service-library-catalog-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://travis-ci.com/alex-foleon/service-library-catalog-php.svg?branch=main
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/alex-foleon/service-library-catalog-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/alex-foleon/service-library-catalog-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/alex-foleon/service-library-catalog-php
[link-travis]: https://www.travis-ci.com/github/alex-foleon/service-library-catalog-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/alex-foleon/service-library-catalog-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/alex-foleon/service-library-catalog-php
[link-downloads]: https://packagist.org/packages/alex-foleon/service-library-catalog-php
[link-author]: https://github.com/alex-foleon
[link-contributors]: ../../contributors
