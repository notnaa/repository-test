start: up_db run_tests
up_db:
	@echo "Up MySql ..."; \
	docker-compose up -d wise-testing-db
	sleep 10
run_tests:
	@echo "Run unit/functional tests ..."; \
	docker-compose -f docker-compose.yml up --build --abort-on-container-exit
stop:
	@echo "Stop stack ..."; \
	docker-compose down
