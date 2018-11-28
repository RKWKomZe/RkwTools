module.tx_rkwtools {
	settings {
		clearCachePageList = {$module.tx_rkwtools.settings.clearCachePageList}
	}
}

config.tx_extbase.persistence {
	classes {
		#RKW\RkwTools\Domain\Model\SysCategory {
		#	mapping {
		#		tableName = sys_category
		#		recordType =
		#	}
		#}
		#RKW\RkwTools\Domain\Model\Department {
		#	mapping {
		#		tableName = tx_rkwbasics_domain_model_department
		#		recordType =
		#	}
		#}
	}
}

plugin.tx_rkwtools_overview {
	view {
		templateRootPaths.0 = EXT:rkw_tools/Resources/Private/Templates/
		templateRootPaths.1 = {$plugin.tx_rkwtools_overview.view.templateRootPath}
		partialRootPaths.0 = EXT:rkw_tools/Resources/Private/Partials/
		partialRootPaths.1 = {$plugin.tx_rkwtools_overview.view.partialRootPath}
		layoutRootPaths.0 = EXT:rkw_tools/Resources/Private/Layouts/
		layoutRootPaths.1 = {$plugin.tx_rkwtools_overview.view.layoutRootPath}
	}
	persistence {
		storagePid = {$plugin.tx_rkwtools_overview.persistence.storagePid}
		#recursive = 1
	}
	features {
		#skipDefaultArguments = 1
	}
	mvc {
		#callDefaultActionIfActionCantBeResolved = 1
	}

	settings {
		cache {
			ttl = {$plugin.tx_rkwtools_overview.settings.cache.ttl}
		}
		pageTypeAjax = {$plugin.tx_rkwtools_overview.settings.pageTypeAjax}
		headerCrop = {$plugin.tx_rkwtools_overview.settings.headerCrop}
		contentCrop = {$plugin.tx_rkwtools_overview.settings.contentCrop}
		footerCrop = {$plugin.tx_rkwtools_overview.settings.footerCrop}
	}
}

tx_rkwtools_overview_ajax = PAGE
tx_rkwtools_overview_ajax {
	typeNum = {$plugin.tx_rkwtools_overview.settings.pageTypeAjax}
	config {

		disableAllHeaderCode = 1
		xhtml_cleaning = 0
		admPanel = 0
		no_cache = 0
		debug = 0

		additionalHeaders.10.header = Content-type: application/json
		metaCharset = utf-8

		index_enable = 0
		index_metatags = 0
		index_externals = 0
	}

	10 = USER_INT
	10 {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		extensionName = RkwTools
		pluginName = Overview
		vendorName = RKW
		switchableControllerActions {
			Tool {
				1 = list
			}
		}
		view < plugin.tx_rkwtools_overview.view
		persistence < plugin.tx_rkwtools_overview.persistence
		settings < plugin.tx_rkwtools_overview.settings
	}
}


plugin.tx_rkwtools.libs {

	responsiveImageThumbnail = IMAGE
	responsiveImageThumbnail {

		file {
			import.current = 1
			treatIdAsReference = 1
			maxW = 450
		}


		# Inherit configuration from tt_content and rkw_basics
		layout < tt_content.image.20.1.layout
		layoutKey = picture
		sourceCollection < plugin.tx_rkwbasics.libs.responsiveImages.sourceCollection

		# set configuration for sourceCollection
		sourceCollection {

			mobile.maxW.override = 450
			mobile.maxW.override.if {
				value = {$plugin.tx_rkwbasics.settings.responsiveImages.breakpoints.mobile}
				isLessThan = 450
			}
			mobileRetina2.maxW.override < .mobile.maxW.override

			tablet.maxW.override < .mobile.maxW.override
			tablet.maxW.override.if.value = {$plugin.tx_rkwbasics.settings.responsiveImages.breakpoints.tablet}
			tabletRetina2.maxW.override < .tablet.maxW.override
			tabletRetina3.maxW.override < .tablet.maxW.override

			desktop.maxW.override < .mobile.maxW.override
			desktop.maxW.override.if.value = {$plugin.tx_rkwbasics.settings.responsiveImages.breakpoints.desktop}
			desktopRetina2.maxW.override < .desktop.maxW.override
		}
	}

	responsiveLogoThumbnail < .responsiveImageThumbnail
	responsiveLogoThumbnail {
		file.maxW = 450
		sourceCollection {

			mobile.maxW.override = 440
			mobile.maxW.override.if.isLessThan = 440
		}
	}


	# PDF Thumbnails
	responsivePdfThumbnail = IMAGE
	responsivePdfThumbnail {

		file {
			import.current = 1
			treatIdAsReference = 1

			ext = png
			maxW = 215
		}

		# Inherit configuration from tt_content
		layout < tt_content.image.20.1.layout
		layoutKey = picture
		sourceCollection < plugin.tx_rkwbasics.libs.responsiveImages.sourceCollection

		# set configuration for sourceCollection
		sourceCollection {

			mobile.maxW.override = 215
			mobile.maxW.override.if {
				value = {$plugin.tx_rkwbasics.settings.responsiveImages.breakpoints.mobile}
				isLessThan = 215
			}
			mobileRetina2.maxW.override < .mobile.maxW.override

			tablet.maxW.override < .mobile.maxW.override
			tablet.maxW.override.if.value = {$plugin.tx_rkwbasics.settings.responsiveImages.breakpoints.tablet}
			tabletRetina2.maxW.override < .tablet.maxW.override
			tabletRetina3.maxW.override < .tablet.maxW.override

			desktop.maxW.override < .mobile.maxW.override
			desktop.maxW.override.if.value = {$plugin.tx_rkwbasics.settings.responsiveImages.breakpoints.desktop}
			desktopRetina2.maxW.override < .desktop.maxW.override
		}
	}
}