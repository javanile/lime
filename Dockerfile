FROM php:7.4-cli

RUN apt-get update && apt-get install -y git && rm -r /var/lib/apt/lists/*
RUN git clone https://github.com/rvanvelzen/lime.git /opt/lime

COPY lime.sh /usr/local/bin/lime
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint

WORKDIR /app

ENTRYPOINT [ "docker-entrypoint" ]

CMD [ "cat" ]
