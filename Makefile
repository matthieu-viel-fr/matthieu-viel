.PHONY: up down build export dev logs shell clean

up:
	docker compose up

dev:
	docker compose up --build

down:
	docker compose down

build:
	docker compose build

export:
	docker compose exec web php export.php

shell:
	docker compose exec web sh

logs:
	docker compose logs -f

clean:
	rm -f dist/*.html dist/en/*.html dist/audit/index.html
