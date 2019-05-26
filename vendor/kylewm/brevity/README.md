# brevity-php

[![Build Status](https://travis-ci.org/kylewm/brevity-php.svg?branch=master)](https://travis-ci.org/kylewm/brevity-php)

A small utility to count characters, autolink, and shorten posts to an
acceptable tweet-length summary.

This is a port of the Python module of the same name. Please refer to
https://github.com/kylewm/brevity for documentation.

Note that this module depends on the `mb_` string methods to be
available. I get the best results by setting

```php
mb_internal_encoding('UTF-8');
```

somewhere in my project.

## Installation

If you're using Composer, you can simply `composer require kylewm/brevity`.

Otherwise, TODO

## Usage

### tweetLength($text)

Find out how many characters a message will use on Twitter with
`tweetLength()`:

```php
$brevity = new \Kylewm\Brevity\Brevity();
$length = $brevity->tweetLength('Published my first npm www.npmjs.com/package/brevity and composer packagist.org/packages/kylewm/brevity packages today!');
echo $length;  // 99
```

This text is 119 characters but, due to t.co wrapping, will only use
99 characters.

### autolink($text)

Convert URLs in plaintext to HTML links.

```php
$brevity = new \Kylewm\Brevity\Brevity();
$html = $brevity->autolink("I'm a big fan of https://en.wikipedia.org/wiki/Firefly_(TV_series) (and its creator https://en.wikipedia.org/wiki/Joss_Whedon)");
echo $html;
```

Note that brevity handles parentheses and other punctuation as you'd
expect.

### shorten($text)

The `shorten($text)` function takes a message of any length and
shortens it to a Tweet-length of 280 characters, adding an ellipsis at
the end of it is truncated. It will not truncate a word or URL in the
middle. Shorten takes a few *optional* parameters that change the way
the tweet is formed. Any of these parameters can be `false`.

- `$permalink` - included after the ellipsis if and only if the text
  is shortened. Must be a URL or false.
- `$shortpermalink` - included in parentheses at the end of tweets
  that are not shortened. Must be a URL or false.
- `$shortpermacitation` - included in parentheses at the end of tweets
  that are not shortened. Must *not* be a URL, e.g. `ttk.me t4fT2`
- `$formatAsTitle` - take the text as a title of a longer
  article. Always formats as "Title: $permalink" or "Title…
  $permalink" if shortened.

```php
$brevity = new \Kylewm\Brevity\Brevity();
$permalink = "https://kylewm.com/2016/01/brevity-shortens-notes";
$longnote = "Brevity (github.com/kylewm/brevity-php) shortens notes that are too long to fit in a single tweet. It can also count characters to help you make sure your note won't need to be shortened!";
$tweet = $brevity->shorten($longnote, $permalink);
echo $tweet;
```

## Changes
- 0.2.10 - 2017-11-25: Account for 280 character limit and multi-byte character
  weights. Also backports some fixes from the python library.
- 0.2.8 - 2016-04-19: Support article+media format
- 0.2.5 - 2016-01-29: Changed namespace from Kylewm to Kylewm\Brevity
  for better PSR-0 compatibility.
