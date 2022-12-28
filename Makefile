
prod_down:
	docker-compose -f docker-compose_prod.yml down

prod_exec_php: 
	docker-compose -f docker-compose_prod.yml exec -it php /bin/sh

prod_log_php:
	docker-compose -f docker-compose_prod.yml logs php --follow

prod_log_nginx:
	docker-compose -f docker-compose_prod.yml logs nginx --follow

prod_build:
	docker-compose -f docker-compose_prod.yml build

prod:
	docker-compose -f docker-compose_prod.yml up -d
