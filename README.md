# Custom service product type for Magento

This extension adds a new product type called Service to Magento. This product type is actually the Virutal product type
but with custom logic modifications.

## Features

  * The price of the Service is default 0.
  * The price of the Service is defined by the user.
  * The final price of the Service when order is placed, is the user-defined price PLUS a service margin.
  * The service margin is configurable in the backend, per website.
  * The shopping cart can only contain one service at a time.
  * Services and other products may not be in the shopping cart at the same time.

