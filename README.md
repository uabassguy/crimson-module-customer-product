## Installation:
Add to composer json:

Under "repositories"
```
{
        "type": "vcs",
        "url": "https://github.com/uabassguy/crimson-module-customer-product"
}
```

Under "require-dev"
```
    "crimson/module-customer-product": "dev-master"
```

Run the following commands:

``composer update;``
 
``bin/magento setup:upgrade;``

The tab ``Product Range Search`` will be added under customer account

Validation will only allow numbers where the high value does not exceed 5x the value of low. 

## Known Issues:
- MSI is not properly pulling qty of products in 2.4.5, qty shows as 0
- Products that are simple with a configurable parent do not have the correct url
