FROM php:7-cli
RUN docker-php-ext-install -j$(nproc) mbstring fileinfo
COPY . /usr/src/didock
WORKDIR /usr/src/didock
ENTRYPOINT ["bin/didock"]
