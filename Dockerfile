FROM mojdigital/wordpress-base:latest

ADD . /bedrock

WORKDIR /bedrock

ARG COMPOSER_USER
ARG COMPOSER_PASS

# Set execute bit permissions before running build scripts
RUN chmod +x bin/* && sleep 1 && \
    make deep-clean && \
    bin/composer-auth.sh && \
    npm install -g bower gulp-cli && echo "{ \"allow_root\": true }" > /root/.bowerrc && \
    make build && \
    rm -f auth.json
