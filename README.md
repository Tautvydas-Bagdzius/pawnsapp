### Setup:
* `sail up`
* Run `sail artisan app:prepopulate-profiling-questions` to seed profiling questions

## Documentation in local environment:
* http://localhost/swagger
* Added `postman_collection.json` (Rather imperfect, but should help with testing)
* 2 tokens endpoints to help out testing - CSRF and then issued user's bearer token

## To test global stats command manually:
* `sail artisan app:daily-stats`