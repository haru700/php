(function($) {
	$.fn.extend({
		hint: function(label) {
			var getClone = function(input, type) {
				type = type || 'text';
				var clone = document.createElement('input');
				clone.type = type;
				if(input.size) clone.size = input.size;
				if(input.value) clone.value = input.value;
				if(input.name) clone.name = input.name;
				if(input.id) clone.id = input.id;
				if(input.className) clone.className = input.className;
				return $(clone);
			};
			
			this.each(function() {
				var input = $(this);
				
				if(input.attr('type') == 'password') {
					label = getClone(input).val(label).addClass('eve-field-text-hint').hide();
					input.after(label);
					
					if(input.val().length == 0) {
						input.hide().next().show();
					}
					
					label.focus(function() {
						label.hide().prev().show().focus();
					});
					
					input.blur(function() {
						if(input.val().length == 0) {
							input.hide().next().show();
						}
					});
					
					return;
				}
				
				if(input.val().length == 0) {
					input.val(label).addClass('eve-field-text-hint');
				}
				
				input.focus(function() {
					input.removeClass('eve-field-text-hint');
					if(input.val() == label) {
						input.val('');
					}
				}).blur(function() {
					if(input.val().length == 0) {
						input.val(label).addClass('eve-field-text-hint');
					}
				});
				
			});
		}
	});
})(jQuery);