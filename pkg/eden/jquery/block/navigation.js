(function($) {
	$.fn.extend({
		navigation: function(options) {
			$(this).each(function() {
				var self 		= $(this),
					body		= $('div.eve-block-navigation-body', self),
					items		= $('li', body),
					
					item 		= 'div.eve-block-navigation-item',
					icon 		= 'span.eve-block-navigation-icon',
					label 		= 'a.eve-block-navigation-label',
					
					regular 	= 'ui-state-default',
					disabled 	= 'ui-state-disabled',
					highlight 	= 'ui-state-highlight',
					active 		= 'ui-state-active';
				
				var on = {};
				
				setTimeout(function() {
					items.live('mouseover', function(e) {
						var $this = $(this);
						$this.children(item).addClass(highlight);
						$this.children('ul').stop().css('opacity', 1).show();
						on[items.index($this)] = true;
					});
					
					items.live('mouseout', function() {
						var $this = $(this);
						$this.children(item).removeClass(highlight);
						$this.children('ul').fadeOut(500);
					});
					
					items.live('click', function() {
						$('ul', items).hide();
					});
				}, 1);			
			});
		}
	});
})(jQuery);