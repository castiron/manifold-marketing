## Search Plugin

Frontend search component for the queequeg backend.

You'll need something like this in your `Plugin.php` file.

```
$this->app->bind(SearchQuery::class, function ($app) {
    return new Query(function($index = null, $type = null) {
        if ($type) {
            return "/search/moca-la/$type/_search";
        }
        return "/search/moca-la/_search";
    }); 
});
```