# Ratings Plugin for Craft
Plugin to rate craft entries with simple statistics

## Requirements
This plugins depends on jquery and the [raty](https://github.com/wbotelhos/raty) plugin.

## Installation

To install Ratings, follow these steps:

1.  Install via composer or upload the ratings/ folder to your craft/plugins/ folder.
2.  Go to Settings > Plugins from your Craft control panel and enable the Ratings plugin.

## Usage

Include css

    <link rel="stylesheet" href="/vendor/raty/lib/jquery.raty.css" media="screen" />
    <link rel="stylesheet" href="{{ resourceUrl('ratings/ratings.css') }}" media="screen" />

Include javascript

    <script src="{{ resourceUrl('ratings/ratings.js') }}"></script>
    <script src="/vendor/raty/lib/jquery.raty.js"></script>


Include the folowing code in your template

    <div class="raty" data-entry-id="{{ entry.id }}" data-given-score="{{ craft.ratings.of(entry.id) / 2 }}"></div>

### Data attrbitues

- data-name: Name of the hidden input
- data-entry-id: Id of the entry to rate
- data-given-score: Score in number of starts
- data-click-submit: Submit rating on click, can be set to false