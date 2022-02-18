## MediaWiki Stakeholders Group - Components
# REL1_35-VueJS3-Shim for MediaWiki

**This code is meant to be executed within the MediaWiki application context. No standalone usage is intended.**

**This component is only meant to be used with MediaWiki 1.35!**

## Use in a MediaWiki extension

Add `"mwstake/mediawiki-component-rel135vue3shim": "~1.0"` to the `require` section of your `composer.json` file.

Explicit initialization is required. This can be archived by
- either adding `"callback": "mwsInitComponents"` to your `extension.json`/`skin.json`
- or calling `mwsInitComponents();` within you extensions/skins custom `callback` method

See also [`mwstake/mediawiki-componentloader`](https://github.com/hallowelt/mwstake-mediawiki-componentloader).

## Only MediaWiki 1.35

This component must only be used in MW 1.35 context. Make sure it is used in a very isolated context (e.g. on a SpecialPage). There is some risk of VueJS version collision!