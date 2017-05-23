(function($) {
	var number_format = function(number, decimals, dec_point, thousands_sep) {
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	};
	var htmlspecialchars = function(string, quote_style, charset, double_encode) {
		var optTemp = 0,
			i = 0,
			noquotes = false;
		if (typeof quote_style === 'undefined' || quote_style === null) {
			quote_style = 2;
		}
		string = string.toString();
		if (double_encode !== false) { // Put this first to avoid double-encoding
			string = string.replace(/&/g, '&amp;');
		}
		string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;');
	
		var OPTS = {
			'ENT_NOQUOTES': 0,
			'ENT_HTML_QUOTE_SINGLE': 1,
			'ENT_HTML_QUOTE_DOUBLE': 2,
			'ENT_COMPAT': 2,
			'ENT_QUOTES': 3,
			'ENT_IGNORE': 4
		};
		if (quote_style === 0) {
			noquotes = true;
		}
		if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
			quote_style = [].concat(quote_style);
			for (i = 0; i < quote_style.length; i++) {
				// Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
				if (OPTS[quote_style[i]] === 0) {
					noquotes = true;
				}
				else if (OPTS[quote_style[i]]) {
					optTemp = optTemp | OPTS[quote_style[i]];
				}
			}
			quote_style = optTemp;
		}
		if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
			string = string.replace(/'/g, '&#039;');
		}
		if (!noquotes) {
			string = string.replace(/"/g, '&quot;');
		}
	
		return string;
	};
	var uid = 1;
	$.fn.extend({
		grid: function(options, columns, wysiwyg) {
			$(this).each(function() {
				var self	= $(this);

					head 	= $('div.eve-block-grid-head', this),
					body 	= $('div.eve-block-grid-body', this),
					foot 	= $('div.eve-block-grid-foot', this),
					frame 	= $('div.eve-block-grid-frame', this),
					
					action	= $('span.eve-block-grid-action', foot),
					clone	= $('div.eve-block-grid-clone', body),
					
					add		= $('span.eve-block-grid-action-add', foot),
					edit	= $('span.eve-block-grid-action-edit', foot),
					save	= $('span.eve-block-grid-action-save', foot),
					cancel	= $('span.eve-block-grid-action-cancel', foot),
					remove	= $('span.eve-block-grid-action-remove', foot),
					
					first	= $('span.eve-block-grid-action-first', foot),
					prev	= $('span.eve-block-grid-action-prev', foot),
					next	= $('span.eve-block-grid-action-next', foot),
					last	= $('span.eve-block-grid-action-last', foot),
					
					page	= $('span.eve-block-grid-action-page input', foot),
					total	= $('span.eve-block-grid-page-total', foot),
					range	= $('span.eve-block-grid-action-range select', foot),
					
					start	= $('span.eve-block-grid-info-start', foot),
					end		= $('span.eve-block-grid-info-end', foot),
					count	= $('span.eve-block-grid-info-count', foot),
				
					mode 	= null,
				
					highlight 	= 'ui-state-highlight',
					disabled 	= 'ui-state-disabled',
					active 		= 'ui-state-active',
					hover		= 'ui-state-hover',
						
					row		= 'div.eve-block-grid-row',
					column	= 'div.eve-block-grid-column',
					scroll	= 'div.eve-block-grid-scroll',
					label	= 'span.eve-block-grid-label',
					field	= 'span.eve-block-grid-field',
					frameHeight = $('div', frame).height(),
					rowHeight 	= $(row, body).height(),
					activeSort	= null; 
				
				var resize = function() {
					var containerWidth 	= self.parent().width();
					var containerHeight = self.parent().height();
					
					self.width(containerWidth).height(containerHeight);
					
					var scrollSize = (containerWidth - frame.innerWidth()) || 15;
					var headHeight = head.outerHeight(true);
					var footHeight = foot.outerHeight(true);
					
					body.width(containerWidth-scrollSize).height(containerHeight-headHeight-footHeight-scrollSize);
					frame.width(containerWidth).height(containerHeight-headHeight-footHeight);
					foot.outerWidth(containerWidth);
					
					frameHeight = $('div', frame).height();
					rowHeight 	= $(row, body).height();
						
				};
				
				//$(window).resize(function() {setTimeout(function() {resize();}, 500);});
				setTimeout(function() {resize();}, 100);
				self.data('eve-block-grid-resize', resize);
				
				//sorting UI
				$('div.eve-block-grid-sort', head).data('ui-grid-sort', false).click(function(e) {
					e.preventDefault();
					var $this = $(this);
					
					activeSort = $this;
					
					switch($this.data('ui-grid-sort')) {
						case false:
							$('div.eve-block-grid-sort').not($this).
								data('ui-grid-sort', false).
								css('cursor', 'n-resize').
								find('a').
								addClass('ui-icon-triangle-2-n-s');
								
							$('a', $this).removeClass('ui-icon-triangle-2-n-s').
								addClass('ui-icon-triangle-1-n');
							
							$this.data('ui-grid-sort', 'ASC').css('cursor', 's-resize');
							break;
						case 'ASC':
							$('a', $this).removeClass('ui-icon-triangle-1-n').
								addClass('ui-icon-triangle-1-s');
							
							$this.data('ui-grid-sort', 'DESC').css('cursor', 'n-resize');
							break;
						case 'DESC':
							$('a', $this).removeClass('ui-icon-triangle-1-s').
								addClass('ui-icon-triangle-1-n');
							
							$this.data('ui-grid-sort', 'ASC').css('cursor', 's-resize');
							break;
					}
					
					$(frame).scrollTop(0).scrollLeft(0);
					
					self.trigger('ui-grid-sort', {
						sort: $this.parent().attr('title'), 
						order: $this.data('ui-grid-sort'),
						page: page.val(), 
						range: range.val() });
					
					return false;
				});
				
				//searching ui
				$('div.eve-block-grid-search input', head).keypress(function(e) {
					if(e.keyCode != 13 && e.charCode != 13) {
						return;
					}
					
					var keywords = {};
					
					$('div.eve-block-grid-search input', head).each(function() {
						if(this.value.length == 0) {
							return;
						}
						
						var key = $(this).parent().parent().parent().attr('title');
						keywords[key] = this.value;
					});
					
					$(frame).scrollTop(0).scrollLeft(0);
					
					self.trigger('ui-grid-search', {
						keywords: keywords,					
						sort: activeSort ? activeSort.parent().attr('title') : null, 
						order: activeSort ? activeSort.data('ui-grid-sort') : null,
						page: page.val(), 
						range: range.val() });
				});
				
				//scrolling UI considering pinned columns
				frame.bind('scroll', function() {
					var $this = $(this);
					$(column, self).not('div.eve-block-grid-pin').css('left', -$this.scrollLeft()+'px');
					$(scroll, body).css('top', -$this.scrollTop()+'px');
				});
				
				//when you hover over a row it should highlight
				$(row).live('mouseover', function() {
					$('span.eve-block-grid-label', this).addClass(active);
				});
				
				$(row).live('mouseout', function() {
					$('span.eve-block-grid-label', this).removeClass(active);
				});
				
				//when you click a row we should set it to active
				//if it's in edit mode, we should cancel edit mode
				//only if the row clicked is not in edit mode
				$(row).live('click', function(e, chain) {
					if(mode != null) {
						if($(label, this).hasClass(highlight)) {
							return;
						}
						
						if(!chain) {
							$(cancel).trigger('click');
						}
					}
					
					var index = $(this).parent().children().index(this);
					
					if(e.ctrlKey || e.metaKey || chain) {
						$(label, this).toggleClass(highlight);
						$(field, this).toggleClass(highlight);	
					} else if (e.shiftKey) {
						var $this = $(this);
						do {
							$(label, $this).addClass(highlight);
							$(field, $this).addClass(highlight);
							if($this.prev().find('span.eve-block-grid-label.ui-state-highlight').size() > 0) {
								break;
							}
							
							$this = $this.prev();
						} while($this.hasClass('eve-block-grid-row'));
						document.getSelection().removeAllRanges();
					} else {
						$('span.eve-block-grid-label.ui-state-highlight', body).removeClass(highlight);
						$('span.eve-block-grid-field.ui-state-highlight', body).removeClass(highlight);
						$(label, this).addClass(highlight);
						$(field, this).addClass(highlight);
					}
					
					if($(row+' span.ui-state-highlight', self).size() > 0) {
						$(edit, foot).removeClass(disabled);
						$(remove, foot).removeClass(disabled);
					} else {
						$(edit, foot).addClass(disabled);
						$(remove, foot).addClass(disabled);
					}
					
					if(!chain) {
						self.trigger('ui-grid-select', {row: this});
					}
				});
				
				//on foot action hover toggle highlight
				$(action).hover(function() {
					if(!$(this).hasClass(disabled)) {
						$(this).addClass(hover);
					}
				}, function() {
					$(this).removeClass(hover);
				});
				
				//on remove click, remove all active rows
				$(remove).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					self.trigger('ui-grid-remove', {rows: $('span.eve-block-grid-label.ui-state-highlight', body).parent().parent()});
					
					$('span.eve-block-grid-label.ui-state-highlight', body).each(function() {
						$(this).parent().parent().remove();
					});
					
					return false;
				});
				
				//on add click
				//deactivate highlighted rows
				//clone first row
				//prepend to body
				//trigger clone row click
				//trigger edit click
				$(add).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					if(mode == null) {
						$('span.eve-block-grid-field.ui-state-highlight', body).removeClass(highlight);
						$('span.eve-block-grid-label.ui-state-highlight', body).removeClass(highlight);
					}
					
					var first = clone.clone().
						addClass('eve-block-grid-new').
						removeClass('eve-block-grid-clone').
						prependTo($(scroll, body));
					
					$('textarea.eve-block-grid-wysiwyg', first).each(function() {
						var id = $(this).attr('id')+'-'+(uid++);
						$('textarea.eve-block-grid-wysiwyg', first).attr('id', id);
						CKEDITOR.replace(this, wysiwyg);
					});
					
					first.trigger('click', true);
					$(edit).trigger('click', true); 
					$(add).removeClass(disabled);
					$(edit).trigger('click', true);
					
					mode = 'add';
					
					$('span.eve-block-grid-field.ui-state-highlight', body).each(function() {
						var textarea = $('textarea', this);
						if(textarea.size() == 0) {
							return;	
						}
						
						var height = textarea.height();
						
						$(this).parent().parent().height(height);
						
						$('div', frame).height($('div', frame).height() + height - rowHeight);
					});
					
					self.trigger('ui-grid-add', { row: first});
					
					return false;
				});
				
				//on edit click, turn all active rows into fields
				//enable save and cancel buttons
				//disable add, edit and remove buttons
				//only do this when edit button is not disabled
				$(edit).click(function(e, chain) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					mode = 'edit';
					$(this).addClass(disabled);
					$(add).addClass(disabled);
					$(remove).addClass(disabled);
					$(save).removeClass(disabled);
					$(cancel).removeClass(disabled);
					$('span.eve-block-grid-label.ui-state-highlight', body).hide();
					$('span.eve-block-grid-field.ui-state-highlight', body).
						css('display', 'block').each(function() {
						var textarea = $('textarea', this);
						if(textarea.size() == 0) {
							return;	
						}
						
						var height = textarea.height();
						
						$(this).parent().parent().height(height);
						
						$('div', frame).height($('div', frame).height() + height - rowHeight);
					});
					
					if(!chain) {
						self.trigger('ui-grid-edit', $('span.eve-block-grid-label.ui-state-highlight', body).parent().parent());
					}
					
					return false;
				});
			
				//on cancel click
				//disable save and cancel buttons
				//disable edit and remove buttons
				//deactivate highlighted rows
				//revert field values
				//remove new rows
				//enable add button
				//only do this if cancel is enabled
				$(cancel).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					$(add).removeClass(disabled);
					
					$(this).addClass(disabled);	
					$(save).addClass(disabled);
					$(edit).addClass(disabled);
					$(remove).addClass(disabled);
					
					self.trigger('ui-grid-cancel', {rows: $('span.eve-block-grid-label.ui-state-highlight', body).parent().parent()});
					
					$('div.eve-block-grid-new', body).remove();
					
					$('span.eve-block-grid-field.ui-state-highlight', body).each(function() {
						$('input, select, textarea', this).val($(this).parent().attr('title'));
						$('textarea.eve-block-grid-wysiwyg', this).each(function() {
							CKEDITOR.instances[this.id].setData(this.innerHTML);
						});
						
						var textarea = $('textarea', this);
						if(textarea.size() == 0) {
							return;	
						}
						
						$(this).parent().parent().height(rowHeight);
					});
					
					$('div', frame).height(frameHeight);
					$('span.eve-block-grid-label.ui-state-highlight', body).removeClass(highlight).show();
					$('span.eve-block-grid-field.ui-state-highlight', body).removeClass(highlight).hide();
					mode = null;
					
					return false;
				});
				
				//on save click
				//disable save and cancel buttons
				//disable edit and remove buttons
				//deactive all hightlighted rows
				//enable add button
				$(save).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
				
					$(this).addClass(disabled);	
					$(cancel).addClass(disabled);
					$(edit).addClass(disabled);
					$(remove).addClass(disabled);
					$(add).removeClass(disabled);
					
					var rows = [], data = [];
					
					$('span.eve-block-grid-field.ui-state-highlight', body).each(function() {
						$('textarea.eve-block-grid-wysiwyg', this).each(function() {
							this.innerHTML = CKEDITOR.instances[this.id].getData();
						});
						
						var value = $('input, select, textarea', this).val();
						
						if(!value) {
							return;
						}
						
						var label = value;
						
						$(this).parent().attr('title', value);
						
						if(!isNaN(parseFloat(value)) && isFinite(value)) {	
							label = (columns[index].prefix || '')+
								number_format(value, 
								columns[index].places, 
								columns[index].decimal,
								columns[index].separator);
						}
						
						$(this).prev().html(htmlspecialchars(label, 'ENT_QUOTES'));
						
						rows.push($(this).parent().parent().get(0));
					});
					
					$('span.eve-block-grid-field.ui-state-highlight', body).each(function() {
						var textarea = $('textarea', this);
						if(textarea.size() == 0) {
							return;	
						}
						
						$(this).parent().parent().height(rowHeight);
					});
					
					if(rows.length > 0) {
						rows = $.unique(rows);
						$(rows).each(function(i) {
							var values = {};
							$(this).removeClass('eve-block-grid-new').children(column).each(function(j) {
								values[columns[j].key] = this.title;
							});
							
							data[i] = values;
						});
					}
					
					//frameHeight = 
					
					$('div', frame).height(frameHeight);
					$('span.eve-block-grid-label.ui-state-highlight', body).removeClass(highlight).show();
					$('span.eve-block-grid-field.ui-state-highlight', body).removeClass(highlight).hide();	
					
					mode = null;
					
					self.trigger(
						'ui-grid-save', {
							data: data, 
							rows: rows,
							sort: activeSort ? activeSort.parent().attr('title') : null, 
							order: activeSort ? activeSort.data('ui-grid-sort') : null,
							page: page.val(), 
							range: range.val() });
					
					return false;
				});
				
				//Pagination - on first button click
				//set text field to 1
				//disable the first and prev button
				//enable the next and last button
				//update pagination info
				$(first).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					page.val(1);
					start.html(1);
					end.html(range.val());
					
					$(this).addClass(disabled);
					$(prev).addClass(disabled);
					
					$(next).removeClass(disabled);
					$(last).removeClass(disabled);
					
					$(frame).scrollTop(0).scrollLeft(0);
					
					self.trigger('ui-grid-pagination', {
						page: page.val(), 
						range: range.val(),
						sort: activeSort ? activeSort.parent().attr('title') : null, 
						order: activeSort ? activeSort.data('ui-grid-sort') : null });
					
					return false;
				});
				
				//Pagination - on prev button click
				//set text field to - 1
				//disable the first and prev button if page is 1
				//enable the next and last button
				//update pagination info
				$(prev).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					var value = page.val() - 1;
					
					if(value < 1) {
						return false;
					}
					
					page.val(value);
					
					var rangeValue 	= parseInt(range.val());
					var startValue 	= (value * rangeValue) - rangeValue + 1;
					var endValue 	= value * rangeValue;
					
					start.html(startValue);
					end.html(endValue);
					
					if(value == 1) {
						$(this).addClass(disabled);
						$(first).addClass(disabled);
					}
					
					$(next).removeClass(disabled);
					$(last).removeClass(disabled);
					
					$(frame).scrollTop(0).scrollLeft(0);
					
					self.trigger('ui-grid-pagination', {
						page: page.val(), 
						range: range.val(),
						sort: activeSort ? activeSort.parent().attr('title') : null, 
						order: activeSort ? activeSort.data('ui-grid-sort') : null });
					
					return false;
				});
				
				//Pagination - on prev button click
				//set text field to + 1
				//disable the next and last button if page is the last page
				//enable the first and prev button
				//update pagination info
				$(next).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					var value = parseInt(page.val()) + 1;
					var pages = total.html();
					if(value > pages) {
						return false;
					}
					
					page.val(value);
					
					var rangeValue 	= parseInt(range.val());
					var startValue 	= (value * rangeValue) - rangeValue + 1;
					var endValue 	= value * rangeValue;
					
					if(endValue > count.html()) {
						endValue = count.html();
					}
					
					start.html(startValue);
					end.html(endValue);
					
					if(value == pages) {
						$(this).addClass(disabled);
						$(last).addClass(disabled);
					}
					
					$(first).removeClass(disabled);
					$(prev).removeClass(disabled);
					
					$(frame).scrollTop(0).scrollLeft(0);
					
					self.trigger('ui-grid-pagination', {
						page: page.val(), 
						range: range.val(),
						sort: activeSort ? activeSort.parent().attr('title') : null, 
						order: activeSort ? activeSort.data('ui-grid-sort') : null });
					
					return false;
				});
				
				//Pagination - on prev button click
				//set text field to last page
				//disable the next and last button
				//enable the first and prev button
				//update pagination info
				$(last).click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					page.val(total.html());
					
					var startValue 	= ((parseInt(total.html())-1) * parseInt(range.val())) + 1;
					var endValue 	= count.html();
					
					start.html(startValue);
					end.html(endValue);
					
					$(this).addClass(disabled);
					$(next).addClass(disabled);
					
					$(first).removeClass(disabled);
					$(prev).removeClass(disabled);
					
					$(frame).scrollTop(0).scrollLeft(0);
					
					self.trigger('ui-grid-pagination', {
						page: page.val(), 
						range: range.val(),
						sort: activeSort ? activeSort.parent().attr('title') : null, 
						order: activeSort ? activeSort.data('ui-grid-sort') : null});
					
					return false;
				});
				
				//Pagination - on range change
				//set text field to last page
				//disable the next and last button
				//enable the first and prev button
				//update pagination info
				$(range).change(function(e) {
					var rangeValue = parseInt($(this).val());
					var startValue = parseInt(start.html());
					var countValue = parseInt(count.html());
					
					//what's the start page? 32 pages = 800 items / 25 range, 26 = 32 pages 
					
					var startPage 	= Math.ceil(startValue / rangeValue);
					var totalPages 	= Math.ceil(countValue / rangeValue);
					
					if(startPage > totalPages) {
						startPage = totalPages;
					}
					
					if(startPage == 1) {				
						$(first).addClass(disabled);
						$(prev).addClass(disabled);
					} 
					
					if(startPage == totalPages) {
						$(next).addClass(disabled);
						$(last).addClass(disabled);
					}
					
					var endValue = startValue + rangeValue - 1;
					
					if(endValue > countValue) {
						endValue = countValue;
					}
					
					page.val(startPage);
					total.html(totalPages);
					end.html(endValue);
					
					
					$(last).removeClass(disabled);
					$(next).removeClass(disabled);
					
					$(first).removeClass(disabled);
					$(prev).removeClass(disabled);
					
					if(startPage == 1) {
						$(first).addClass(disabled);
						$(prev).addClass(disabled);
					} else if(startPage == totalPages) {
						$(next).addClass(disabled);
						$(last).addClass(disabled);
					}
					
					$(frame).scrollTop(0).scrollLeft(0).find('div').height(rangeValue * rowHeight);
					
					self.trigger('ui-grid-pagination', {
						page: page.val(), 
						range: range.val(),
						sort: activeSort ? activeSort.parent().attr('title') : null, 
						order: activeSort ? activeSort.data('ui-grid-sort') : null });
				});
			});
			
			return this;
		}
	});
})(jQuery);