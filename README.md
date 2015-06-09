# ratings
Plugin to rate craft entries with simple statistics

# requirements
This plugins depends on jquery and the [raty](https://github.com/wbotelhos/raty) plugin.

# Installation
Include css

    <link rel="stylesheet" href="/vendor/raty/lib/jquery.raty.css" media="screen" />
    <link rel="stylesheet" href="{{ resourceUrl('ratings/ratings.css') }}" media="screen" />

Include javascript

    <script src="{{ resourceUrl('ratings/ratings.js') }}"></script>
    <script src="/vendor/raty/lib/jquery.raty.js"></script>


Include the folowing code in your template

    <div class="raty" data-entry-id="{{ entry.id }}" data-given-score="{{ craft.ratings.of(entry.id) / 2 }}"></div>