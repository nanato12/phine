.PHONY: lint
lint:
	./vendor/bin/phpstan analyse --memory-limit=1G --configuration=./phpstan.neon && \
	./vendor/bin/php-cs-fixer fix --path-mode=intersection --config=./.php-cs-fixer.dist.php --verbose --dry-run --allow-risky=yes ./

.PHONY: fix
fix:
	./vendor/bin/php-cs-fixer fix --path-mode=intersection --config=./.php-cs-fixer.dist.php --verbose --allow-risky=yes ./
