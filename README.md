# ratings
Plugin to rate craft entries with simple statistics

# requirements
This plugins depends on the jquery [raty](https://github.com/wbotelhos/raty) plugin for fancy star ratings

# Installation
Include the folowing code in your template

`<div class="raty" data-entry-id="{{ entry.id }}" data-given-score="{{ craft.ratings.of(entry.id) / 2 }}"></div>`

# Credits
This pkugin is inspired by the [luckystars]() plugin