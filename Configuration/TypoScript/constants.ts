module.tx_rkwtools {
	settings {
		# cat=module.tx_rkwtools; type=string; label=List of PIDs whose cache is to delete, when contents are saved
		clearCachePageList =
	}
}

plugin.tx_rkwtools_overview {
	view {
		# cat=plugin.tx_rkwtools_overview/file; type=string; label=Path to template root (FE)
		templateRootPath = EXT:rkw_tools/Resources/Private/Templates/
		# cat=plugin.tx_rkwtools_overview/file; type=string; label=Path to template partials (FE)
		partialRootPath = EXT:rkw_tools/Resources/Private/Partials/
		# cat=plugin.tx_rkwtools_overview/file; type=string; label=Path to template layouts (FE)
		layoutRootPath = EXT:rkw_tools/Resources/Private/Layouts/
	}
	persistence {
		# cat=plugin.tx_rkwtools_overview//a; type=string; label=Default storage PID
		storagePid =
	}
	settings {
		cache {
			# cat=plugin.tx_rkwtools_overview//a; type=integer; label=Cache time to live
			ttl = 86400
		}
		# cat=plugin.tx_rkwtools_overview//f; type=integer; label=PageType for Ajax Plugin
		pageTypeAjax = 1512989710
		# cat=plugin.tx_rkwtools_overview//a; type=integer; label=Default header text cropping
		headerCrop = 60
		# cat=plugin.tx_rkwtools_overview//a; type=integer; label=Default body text cropping
		contentCrop = 230
		# cat=plugin.tx_rkwtools_overview//a; type=integer; label=Default footer text cropping
		footerCrop = 20
	}
}
