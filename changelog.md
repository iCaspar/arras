# Arras Theme Change Log

## Version 1.7-beta

### Fixes

* Missing Sidebar ID's throwing PHP Notices
* Widgets throwing PHP Notices
* Broken translation functions
* Excerpt sometimes not set in default tapestry settings
* Using non-existant capability in `arras_postheader()`
* Incorrect assignment of comments by type
* Search icon on admin bar blocked when viewed on front end
* Featured image width overflows on single posts
* Redirect Page template renders "white screen of death" when no url supplied
* Redirect Page doesn't recognize `https`
* Redirect Page template uses insecure url assignment and redirect

### Adds

* `.screen-reader-text` CSS class for WP Accessibility Standards
* WP Native Title Tag support
* WP Native Navigation support
* WP Native Custom Background support
* WP Native Custom Logo support
* `ARRAS_URL` constant (used to generate links to theme url in footer)

### Updates

* Uses of `query_posts()` now use new queries instead
* Updates `superfish.js` menu script to current version (1.7.9)
* Theme screenshot
* References to `TEMPLATEPATH` now use `get_template_directory()`
* *Arras Options* and *Post Types &amp; Taxonomy* Options are now located under the *Appearances* section of the Admin menu
* `ARRAS_VERSION` now set from the theme object headers instead of hard-coded.

### Removes

* Deprecated header tags in `style.css`
* Dead links on Arras Options pages
* `user.css` and child theme styles enqueuing, to allow child themes to enqueue their own styles.
* `ARRAS_CUSTOM_FIELDS` definition, to allow child themes to define
* `ARRAS_INHERIT_LAYOUT` and `ARRAS_FORCE_LAYOUT` constants. Layouts in child themes can be set from *Arras Options*
* Admin screen icons (no longer supported by WP)
* Unused `$content_width` setting

## (Versions 1.6.x -- Discontinued)

## Version 1.5.3-RC1

Last version available from the former developer, [Melvin Lee](https://github.com/zyml/arras-theme).