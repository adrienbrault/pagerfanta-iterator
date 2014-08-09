This allows to easily traverse all the pages of a pagerfanta instance:

```php
$pager->setMaxPerPage(10);

foreach (PagerfantaIterator::iterateOverPages($pager) as $page => $pageResults) {

}
```

This allows to easily traverse all the elements of all the pages:

```php
$pager->setMaxPerPage(10);

foreach (PagerfantaIterator::iterateOverElements($pager) as $index => $element) {

}
```
