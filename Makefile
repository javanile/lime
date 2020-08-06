
build:
	docker build -t javanile/lime .

tdd: build
	docker run --rm javanile/lime

