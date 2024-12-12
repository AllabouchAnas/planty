<script type="text/html" id="tmpl-gsf-icons-popup">
	<div id="gsf-popup-icon-wrapper" class="gsf-popup-icon-wrapper mfp-with-anim mfp-hide">
		<div class="gsf-popup-icon-content">
			<div class="gsf-popup-icon-left">
				<div class="gsf-popup-icon-search">
					<input type="text" placeholder="<?php esc_attr_e('Search Icon...','lustria-framework'); ?>"/>
				</div>
				<div class="gsf-popup-icon-font">
					<select>
						<# _.each(data, function(item, index) { #>
							<option value="{{index}}">{{item.label}}</option>
						<# }); #>
					</select>
				</div>
				<div class="gsf-popup-icon-font-link">
					<div class="gsf-popup-icon-font-link-inner">
						<# _.each(data, function(item, fontId) { #>
							<div class="gsf-popup-icon-group-link" data-font-id="{{fontId}}">
								<ul>
									<# var __totalIcons = 0; _.each(item.iconGroup, function(group){ __totalIcons += group.icons.length; });#>
									<# if (item.iconGroup.length > 1) { #>
										<li><a data-id="" href="#"><?php esc_html_e('All Icons','lustria-framework'); ?></a> <span>({{__totalIcons}})</span></li>
									<# } #>
									<# _.each(item.iconGroup, function(group) { #>
										<li><a data-id="{{group.id}}" href="#">{{group.title}}</a> <span>({{group.icons.length}})</span></li>
									<# }); #>
								</ul>
							</div>
						<# }); #>
					</div>
				</div>
			</div>
			<div class="gsf-popup-icon-right">
				<h2 class="gsf-popup-icon-header">
					<span><?php esc_html_e('Select An Icon','lustria-framework'); ?></span>
				</h2>
				<div class="gsf-popup-icon-listing">
					<# _.each(data, function(item, fontId) { #>
						<div class="gsf-popup-icon-group-section" data-font-id="{{fontId}}">
							<h4 class="gsf-popup-icon-group-title"
							    data-msg-all="<?php esc_attr_e('All Icons','lustria-framework'); ?>"
							    data-msg-search="<?php esc_attr_e('Search result for "{0}"','lustria-framework'); ?>"><?php esc_html_e('All Icons','lustria-framework'); ?></h4>
							<ul>
								<# for (var icon in item.icons) { #>
									<li data-group="{{item.icons[icon]}}" title="{{icon}}"><i class="{{icon}}"></i></li>
								<# }; #>
							</ul>
						</div>
						<# }); #>
				</div>
			</div>
		</div>
	</div>
</script>