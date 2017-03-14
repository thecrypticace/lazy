# Lazy Collections

## What

Lazy is a Collection-like wrapper that can operate on iterators one item at a time (on-demand).

Some notes:
1. Lazy works well for one-shot data sources (e.g. `Generator`s)
2. Lazy supports algorithms which run with minimal overhead. Functional algorithms are well suited to this.
3. Lazy collections can convert the underlying data source into an array using `->eager()`. Useful for reiterative purposes.
4. Has convenience methods for simple lazy data generation (e.g. ranges)
5. Has higher-order collection proxy which will allow code like this: `$collection->map->people->map->count()->sum()`

## Why?

Let's say you have this code:
```php
collect($oneMillionNumbers)->filter(function ($n) {
    return $n % 2 === 0;
})->map(function ($n) {
    return $n / 4;
})->filter(function ($n) {
    return $n >= 100;
})
->first()
```

For a small array `$items` the work performed here is trivial. If you take a large array containing 1 million numbers starting at one the work performed is large:
- 1,000,000 iterations in `filter`
- 500,000 iterations in `map`
- 500,000 iterations in `filter`
- one iteration in `first`

Total: 2,000,001 iterations
Total: 2,000,001 function calls

Each one of these iterations also incurs the overhead of a function call.

If you replace that call to `collect` with `lazy`:
```php
lazy($oneMillionNumbers)->filter(function ($n) {
    return $n % 2 === 0;
})->map(function ($n) {
    return $n / 4;
})->filter(function ($n) {
    return $n >= 100;
})
->first()
```

These are the stats:
- 400 iterations in `filter`
- 200 iterations in `map`
- 200 iterations in `filter`
- one iteration in `first`

Since these iterations happen on demand it's not 801 iterations. It's 400 for the entire set. _Lazy_ Collections perform the minimal amount of work needed to get the result.

There _are_ 801 function calls. One for each of the "virtual" iterations in each of the operations. Still, this number is far less than the 2,000,001 calls from the loop above.

Total: 400 iterations
Total: 801 function calls

_Lazy_ is effectively performing the same operation as this:

```php
foreach ($oneMillionNumbers as $n) {
    if ($n % 2 === 0) {
        $n = $n / 4;
        if ($n >= 100) {
            return $n;
        }
    }
}
```

tip: `lazy_range(1, 1000000)` will generate a Collection with a range from one to one million.
