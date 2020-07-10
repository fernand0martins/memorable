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

Load bulk development data:
```bash
docker-compose exec php bin/console doctrine:fixtures:load
```

After those, the api documentation should be available in [https://localhost:8443/](https://localhost:8443/) and the assets can be explored and managed in the admin area [https://localhost:444](https://localhost:444)

## Test suit
- for static code analysis run `docker-compose exec php php vendor/bin/psalm`, no errors should be found
- run acceptance/unit tests with`docker-compose exec php php bin/phpunit tests`, tests should pass

# Documentation / notes
- [OpenApi swagger file](swagger_docs.json)
- [Postman Collection](media-repo.postman_collection.json)
- Endpoints are cached in production using varnish, [config is here](api/config/packages/prod/api_platform.yaml), request should have a header "Cache-Control" with values set to "max-age=0, public, s-maxage=3600"
- Searching assets can be done using the example in the Postman collection
- CI integration is done using github actions

## todo
- jwt config
