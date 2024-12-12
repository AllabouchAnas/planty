<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/template" id="tmpl-ube-template-modal">
	<div class="dialog-widget dialog-lightbox-widget dialog-type-buttons dialog-type-lightbox elementor-templates-modal ube-templates-modal">
		<div class="dialog-widget-content dialog-lightbox-widget-content">
			<div class="dialog-header dialog-lightbox-header">
				<div class="elementor-templates-modal__header">
					<div class="elementor-templates-modal__header__logo-area">
						<div class="elementor-templates-modal__header__logo">
						<span class="elementor-templates-modal__header__logo__icon-wrapper">
						<i class="eicon-elementor"></i>
						</span>
							<span class="elementor-templates-modal__header__logo__title"><?php esc_html_e('UBE Templates', 'ube'); ?></span>
						</div>
					</div>
					<div class="elementor-templates-modal__header__items-area">
						<div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--normal elementor-templates-modal__header__item">
							<i class="eicon-close" aria-hidden="true" title="<?php echo esc_attr__('Close', 'ube'); ?>"></i>
							<span class="elementor-screen-only"><?php esc_html_e('Close', 'ube'); ?></span>
						</div>
						<div class="elementor-templates-modal__header__item">
							<input type="search" class="ube-modal-search-template" autocomplete="off" placeholder="<?php echo esc_attr__('Search template...','ube') ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="dialog-message dialog-lightbox-message">
				<div class="dialog-content dialog-lightbox-content">

				</div>
				<div class="dialog-loading dialog-lightbox-loading" style="display: block">
					<div id="elementor-template-library-loading">
						<div class="elementor-loader-wrapper">
							<div class="elementor-loader">
								<div class="elementor-loader-boxes">
									<div class="elementor-loader-box"></div>
									<div class="elementor-loader-box"></div>
									<div class="elementor-loader-box"></div>
									<div class="elementor-loader-box"></div>
								</div>
							</div>
							<div class="elementor-loading-title"><?php esc_html_e('Loading', 'ube'); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-ube-template-modal-content">
	<div class="ube-modal-sidebar">
		<ul>
			<# for (var cate in data.categories) { #>
			<#
				var activeClass = '';
				if (cate === '') {
					activeClass = ' class="active"';
				}
			#>
			<li data-category="{{ cate }}"{{{activeClass}}}>{{ data.categories[cate] }}</li>
			<# } #>
		</ul>
	</div>
	<#
	var noItemClass = '';
	if (data.templates.length === 0) {
		noItemClass = 'no-items';
	}
	#>
	<div class="ube-modal-content {{noItemClass}}">
		<div class="ube-template-list">
			<# for (var index in data.templates) { #>
			<#
			var item = data.templates[index];
			var cateNames = [];
			for (var cateIndex in item.category) {
				var cateSlug = item.category[cateIndex];
				cateNames.push(data.categories[cateSlug] ? data.categories[cateSlug] : cateSlug);
			}

			var noImagePreview = item.preview === '' ? 'no-preview' : '';
			var data_category = '|' + item.category.join('|') + '|';

			#>
			<div class="ube-template-item" data-category="{{data_category}}" data-name="{{item.name}}">
				<div class="ube-template-item-content">
					<div class="ube-template-item-image-preview {{noImagePreview}}" data-content="<?php echo esc_attr__('UBE Template','ube') ?>">
						<# if (item.preview !== '') { #>
						<img src="{{item.preview}}" alt="{{item.name}}">
						<# } #>
					</div>
					<div class="ube-template-item-cate">
						<# for (var cateIndex in cateNames) { #>
						<div>{{ cateNames[cateIndex] }}</div>
						<# } #>
					</div>
					<div class="ube-template-item-info">
						<span>{{item.name}}</span>
						<div class="ube-template-item-insert" data-id="{{index}}" title="<?php echo esc_attr__('Insert Template','ube') ?>">
							<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path></svg>
						</div>
					</div>
				</div>
			</div>
			<# } #>
		</div>
		<div class="ube-template-list-not-found">
			<?php echo esc_html__('Templates not found!','ube') ?>
		</div>
	</div>
</script>