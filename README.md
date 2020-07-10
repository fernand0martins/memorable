# Media Repo

Generated from [Api-Platform](https://github.com/api-platform/api-platform) template, implements a media repository with a restful API.


![CI/CD](https://github.com/fernand0martins/memorable/workflows/CI/CD/badge.svg?branch=master)

# How to run 
To build the docker containers and bring all the containers up:
```bash
docker-compose build
docker-compose up
```

After the api documentation should be available in https://localhost:8443/

## Noteworthy commands:
Database:
```bash
docker-compose exec db psql api -U api-platform -W
```
Password is in the docker-compose.yml file

Console:
```bash
docker-compose exec php bin/console
```

Load data:
```bash
docker-compose exec php bin/console doctrine:fixtures:load
```

### todo
- docker-compose exec php bin/console api:openapi:export --output=swagger_docs.json build swagger documentation
