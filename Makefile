
build:
	chmod +x lime.sh docker-entrypoint.sh
	docker build -t javanile/lime .

tdd: build
	docker run --rm -v ${PWD}:/app javanile/lime test/fixtures/calc/calc.lime
