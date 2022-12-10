DOCKER_REPO="registry.blackforestbytes.com"

DOCKER_NAME=mikescher/website-mscom

NAMESPACE=$(shell git rev-parse --abbrev-ref HEAD)

HASH=$(shell git rev-parse HEAD)

run:
	php -S localhost:8000 -t .

build-docker:
	[ ! -f "DOCKER_GIT_INFO" ] || rm DOCKER_GIT_INFO
	git rev-parse --abbrev-ref HEAD    >> DOCKER_GIT_INFO
	git rev-parse              HEAD    >> DOCKER_GIT_INFO
	git log -1 --format=%cd --date=iso >> DOCKER_GIT_INFO
	git config --get remote.origin.url >> DOCKER_GIT_INFO
	docker build \
	    -t $(DOCKER_NAME):$(HASH) \
	    -t $(DOCKER_NAME):$(NAMESPACE)-latest \
	    -t $(DOCKER_NAME):latest \
	    -t $(DOCKER_REPO)/$(DOCKER_NAME):$(HASH) \
	    -t $(DOCKER_REPO)/$(DOCKER_NAME):$(NAMESPACE)-latest \
	    -t $(DOCKER_REPO)/$(DOCKER_NAME):latest \
	    .

run-docker: build-docker
	mkdir -p ".run-data"
	docker run --rm \
	           --init \
	           --publish 8080:80 \
	           --env "SMTP=0" \
	           --volume "$(shell pwd)/www/config.php:/var/www/html/config.php:ro" \
	           --volume "$(shell pwd)/.run-data/egg:/var/www/html/dynamic/egg" \
	           --volume "$(shell pwd)/.run-data/logs:/var/www/html/dynamic/logs" \
	           $(DOCKER_NAME):latest

run-docker-live: build-docker
	mkdir -p "$(shell pwd)/.run-data"
	docker run --rm   \
	           --init \
	           --publish 8080:80 \
	           --volume "$(shell pwd)/www:/var/www/html/" \
	           --env "SMTP=0" \
	           --volume "$(shell pwd)/www/config.php:/var/www/html/config.php:ro" \
	           --volume "$(shell pwd)/.run-data/egg:/var/www/html/dynamic/egg" \
	           --volume "$(shell pwd)/.run-data/logs:/var/www/html/dynamic/logs" \
	           $(DOCKER_NAME):latest

inspect-docker:
	docker run -ti  \
	           --rm \
	           $(DOCKER_NAME):latest \
	           bash

push-docker: build-docker
	docker image push $(DOCKER_REPO)/$(DOCKER_NAME):$(HASH)
	docker image push $(DOCKER_REPO)/$(DOCKER_NAME):$(NAMESPACE)-latest
	docker image push $(DOCKER_REPO)/$(DOCKER_NAME):latest

clean:
	rm -rf ".run-data"
	git clean -fdx