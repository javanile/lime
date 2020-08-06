
install:
	flex -t scanner/lime_scan_tokens.l > scanner/lime_scan_tokens.c
	gcc scanner/lime_scan_tokens.c -o scanner/lime_scan_tokens

build:
	chmod +x docker-entrypoint.sh
	docker build -t javanile/lime .

push:
	git add .
	git commit -am "push to docker hub"
	git push
	docker push javanile/lime

tdd: build
	docker run --rm -v ${PWD}:/app javanile/lime tests/fixtures/calc/calc.lime > Calc.php
