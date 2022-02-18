<?php

if ( defined( 'MWSTAKE_MEDIAWIKI_COMPONENT_REL135VUE3SHIM_VERSION' ) ) {
	return;
}

define( 'MWSTAKE_MEDIAWIKI_COMPONENT_REL135VUE3SHIM_VERSION', '1.0.0' );

MWStake\MediaWiki\ComponentLoader\Bootstrapper::getInstance()
->register( 'rel135vue3shim', function () {
	$GLOBALS['wgHooks']['ResourceLoaderRegisterModules'][] = function ( $resourceLoader ) {
		$resourceLoader->register( [ 'mwstake-vue3shim' => [
			'localBasePath' => __DIR__,
			'packageFiles' => [
				'resources/src/vue/index.js',
				'resources/src/vue/errorLogger.js',
				'resources/src/vue/i18n.js',
				[
					'name' => 'resources/lib/vue/vue.js',
					'callback' => static function ( ResourceLoaderContext $context, Config $config ) {
						global $IP;
						// Use the development version if development mode is enabled, or if we're in debug mode
						$file = $config->get( 'VueDevelopmentMode' ) || $context->getDebug() ?
							'resources/lib/vue/vue.global.js' :
							'resources/lib/vue/vue.global.prod.js';
						// The file shipped by Vue does var Vue = ...;, but doesn't export it
						// Add module.exports = Vue; programmatically
						return '/*@nomin*/' ."\n" . file_get_contents( __DIR__ . "/$file" ) .
							';module.exports=Vue;';
					},
					'versionCallback' => static function ( ResourceLoaderContext $context, Config $config ) {
						$file = $config->get( 'VueDevelopmentMode' ) || $context->getDebug() ?
							'resources/lib/vue/vue.global.js' :
							'resources/lib/vue/vue.global.prod.js';
						return new ResourceLoaderFilePath( $file );
					}
				],

			],
			'es6' => true,
			'targets' => [ 'desktop', 'mobile' ],
		] ] );

		// Alias for 'vue', for backwards compatibility
		$resourceLoader->register( [ '@mwstake-vue3shim/composition-api' => [
			'localBasePath' => __DIR__,
			'packageFiles' => [
				'resources/src/vue/composition-api.js'
			],
			'dependencies' => [
				'mwstake-vue3shim'
			],
			'targets' => [ 'desktop', 'mobile' ]
		] ] );

		$resourceLoader->register( [ 'mwstake-vuex4shim' => [
			'localBasePath' => __DIR__,
			'packageFiles' => [
				[
					'name' => 'resources/lib/vuex/vuex.js',
					'callback' => static function ( ResourceLoaderContext $context, Config $config ) {
						global $IP;
						// Use the development version if development mode is enabled, or if we're in debug mode
						$file = $config->get( 'VueDevelopmentMode' ) || $context->getDebug() ?
							'resources/lib/vuex/vuex.global.js' :
							'resources/lib/vuex/vuex.global.prod.js';
						// The file shipped by Vuex does var Vuex = ...;, but doesn't export it
						// Add module.exports = Vuex; programmatically, and import Vue
						return '/*@nomin*/' ."\n" ."var Vue=require('mwstake-vue3shim');" .
							file_get_contents( __DIR__ . "/$file" ) .
							';module.exports=Vuex;';
					},
					'versionCallback' => static function ( ResourceLoaderContext $context, Config $config ) {
						$file = $config->get( 'VueDevelopmentMode' ) || $context->getDebug() ?
							'resources/lib/vuex/vuex.global.js' :
							'resources/lib/vuex/vuex.global.prod.js';
						return new ResourceLoaderFilePath( $file );
					}
				],
			],
			'dependencies' => [
				'mwstake-vue3shim',
			],
			'es6' => true,
			'targets' => [ 'desktop', 'mobile' ],
		] ] );
	};
} );
