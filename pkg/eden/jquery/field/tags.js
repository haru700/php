(function($) {
	$.fn.extend({
		tags: function(options) {
			this.each(function() {
				var self 	= $(this);
				var input 	= $('input.eve-field-tags-field', this);
				var remove 	= $('span.eve-field-tags-remove', self);
				var space	= options.insert == 'enter' ?  13 : 32;
				var back	= options.remove == 'delete' ?  46 : 8;
				
				self.click(function() {
					input.focus();	
				});
				
				remove.live('click', function() {
					$(this).parent().remove();
				});
				
				input.keydown(function(e) {
					this.size = this.value.length || 1;
					if(e.keyCode == back && this.value.length == 0) {
						$(this).prev().remove();
						return;
					}
					
					if (e.keyCode != space) {
						return;
					}
					
					e.preventDefault();
					
					if(this.value.length == 0) {
						return false;
					}
					
					var item = $('span.eve-field-tags-item.ui-helper-hidden', self)
						.clone().removeClass('ui-helper-hidden');
					
					$('span.eve-field-tags-label', item).html(this.value);
					$('input', item).val(this.value);
					$(this).before(item);
					this.value = '';
					this.size = 1;
					return false;
				}).bind('autocompleteselect', function(e, ui) {
					$this = $(this);
					setTimeout(function() {
						var item = $('span.eve-field-tags-item.ui-helper-hidden', self)
							.clone().removeClass('ui-helper-hidden');
						
						$('span.eve-field-tags-label', item).html($this.val());
						$('input', item).val($this.val());
						$this.before(item).val('').attr('size', 1);
					}, 1);
				});
			});
		}
	});
})(jQuery);