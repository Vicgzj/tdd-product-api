.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "%s%-30s%s %s\n", "${CYAN}", $$1, "${DEFAULT}",$$2}'

.PHONY: clear_cache
clear_cache: ## Clears the cache
	rm -rf ./cache/*

.PHONY: start
start: ## Start the API
	php -S 127.0.0.1:8000 -t public
