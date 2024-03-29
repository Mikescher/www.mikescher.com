DOCKER_REPO="registry.blackforestbytes.com"

DOCKER_NAME=mikescher/website-mscom

NAMESPACE=$(shell git rev-parse --abbrev-ref HEAD)

HASH=$(shell git rev-parse HEAD)

run:
	php -S localhost:8000 -t .

dgi:
	[ ! -f "DOCKER_GIT_INFO" ] || rm DOCKER_GIT_INFO
	echo -n "VCSTYPE="     >> DOCKER_GIT_INFO ; { echo -n "git" ;                                                                                      echo ""; } >> DOCKER_GIT_INFO
	echo -n "BRANCH="      >> DOCKER_GIT_INFO ; { git rev-parse --abbrev-ref HEAD ;                                                                             } >> DOCKER_GIT_INFO
	echo -n "HASH="        >> DOCKER_GIT_INFO ; { git rev-parse              HEAD ;                                                                             } >> DOCKER_GIT_INFO
	echo -n "COMMITTIME="  >> DOCKER_GIT_INFO ; { git log -1 --format=%cd --date=iso ;                                                                          } >> DOCKER_GIT_INFO
	echo -n "REMOTE="      >> DOCKER_GIT_INFO ; { git remote -v | awk '{print $$2}' | uniq | tr '\n' ';';                                              echo ""; } >> DOCKER_GIT_INFO
	echo -n "MESSAGE="     >> DOCKER_GIT_INFO ; { git log -1 --format=%B | awk '{s=s $$0 "\n"}END{sub(/\n+$$/,"",s);printf "%s",s}' | base64 --wrap=0; echo ""; } >> DOCKER_GIT_INFO



docker: dgi
	docker build \
	    -t $(DOCKER_NAME):$(HASH) \
	    -t $(DOCKER_NAME):$(NAMESPACE)-latest \
	    -t $(DOCKER_NAME):latest \
	    -t $(DOCKER_REPO)/$(DOCKER_NAME):$(HASH) \
	    -t $(DOCKER_REPO)/$(DOCKER_NAME):$(NAMESPACE)-latest \
	    -t $(DOCKER_REPO)/$(DOCKER_NAME):latest \
	    .

run-docker: docker
	mkdir -p ".run-data"
	docker run --rm \
	           -it \
	           --init \
	           --publish 8080:80 \
	           --env "SMTP=0" \
	           --volume "$(shell pwd)/www/config.php:/var/www/html/config.php:ro" \
	           --volume "$(shell pwd)/.run-data/dynamic:/var/www/html/dynamic"    \
	           $(DOCKER_NAME):latest

run-docker-live: docker
	mkdir -p "$(shell pwd)/.run-data"
	docker run --rm   \
	           -it \
	           --init \
	           --publish 8080:80 \
	           --volume "$(shell pwd)/www:/var/www/html/" \
	           --env "SMTP=0" \
	           $(DOCKER_NAME):latest

inspect-docker:
	docker run -ti  \
	           --rm \
	           $(DOCKER_NAME):latest \
	           bash

push-docker:
	docker image push $(DOCKER_REPO)/$(DOCKER_NAME):$(HASH)
	docker image push $(DOCKER_REPO)/$(DOCKER_NAME):$(NAMESPACE)-latest
	docker image push $(DOCKER_REPO)/$(DOCKER_NAME):latest

clean:
	rm -rf ".run-data"
	git clean -fdx