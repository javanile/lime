FROM php:7.4-cli

RUN apt-get update && apt-get install -y flex && rm -r /var/lib/apt/lists/*

COPY . /opt/lime
RUN cd /opt/lime && make install

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint

WORKDIR /app

ENTRYPOINT [ "docker-entrypoint" ]
