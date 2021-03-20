# Pagination for `<Neos.Fusion:Loop />`

Easily configurable component that adds a pagination to `<Neos.Fusion:Loop />`


## Usage

```html
pages = ${q(site).find('[instanceof Neos.Neos:Document]').sort('_index', 'DESC')}

<NeosRulez.FusionLoopPagination:Component.Paginated collection={props.pages} itemsPerPage="4">
  <ul>
    <Neos.Fusion:Loop items={paginatedItems} itemName="item" >
      <li>
        <Neos.Neos:NodeLink node={item}>
          {item.properties.title}
        </Neos.Neos:NodeLink>
      </li>
    </Neos.Fusion:Loop>
  </ul>
</NeosRulez.FusionLoopPagination:Component.Paginated>
```


## Installation

The NeosRulez.Bootstrap.FusionLoopPagination package is listed on packagist (https://packagist.org/packages/neosrulez/fusionlooppagination) - therefore you don't have to include the package in your "repositories" entry any more.

Just run:

```
composer require neosrulez/fusionlooppagination
```


## Author

* E-Mail: mail@patriceckhart.com
* URL: http://www.patriceckhart.com
