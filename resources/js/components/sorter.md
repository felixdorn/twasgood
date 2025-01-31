# Sorter

Sorter waits for the user to drag items in a list, if the user re-orders an item, it fires off a request. It's a thin wrapper around Sortable.js

## Usage

On your list, add a `data-sorter` attribute, to configure the HTTP callback, set the URL in `data-sorter-callback`. Sorter will send a POST request to that URL with a key `list` and the value of each item in the list, usually an ID, taken from a `data-sorter-item` attribute.

To support noscript situations, it is possible to show up and down arrows in a `<noscript></noscript>` tag.
