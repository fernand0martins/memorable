# Media Repo

Generated from [Api-Platform](https://github.com/api-platform/api-platform) template, implements a media repository with a restful API.


![CI/CD](https://github.com/fernand0martins/memorable/workflows/CI/CD/badge.svg?branch=master)

# How to run 
To build and bring all the containers up:
```bash
docker-compose build
docker-compose up
```

Create a new .env file inside ``/api`` named .env.local and fill with your S3 credentials
```text
AWS_REGION=
AWS_BUCKET=
AWS_KEY=
AWS_SECRET=
```

# Documentation
- [OpenApi swagger file](swagger_docs.json)
- [Postman Collection](media-repo.postman_collection.json)
- Endpoints are cached in production using [varnish](api/config/packages/api_platform.yaml), cached requests should have the "Cache-Control" header properly set
- Searching assets can be done using the examples in the Postman collection
- CI integration is done using github actions

# Notes
- Load bulk development data:
```bash
docker-compose exec php bin/console doctrine:fixtures:load
```

- Generating a JWT token:
```bash
 docker-compose exec php bin/console lexik:jwt:generate-token test
```
or

- Create an account using ``/jwt/register`` and create a bearer token by logging in ``/jwt/login`` 

All operations require a JWT token to be passed as a header in the format
``Authorization: Bearer TOKEN_HERE``

After those, the api documentation should be available in [https://localhost:8443/docs/](https://localhost:8443/docs/) and the assets can be explored and managed in the admin area [https://localhost:444](https://localhost:444).
Authentication should be done using the button to authenticate, input ``Bearer TOKEN_HERE`` on the field to validate.

## Test suit
- for static code analysis run `docker-compose exec php php vendor/bin/psalm`, no errors should be found
- run acceptance/unit tests with`docker-compose exec php php bin/phpunit tests`, tests should pass, tests require the ``JWT_TOKEN=Bearer YOUR_TOKEN`` to be set in ``.env.test``
