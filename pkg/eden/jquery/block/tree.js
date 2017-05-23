(function($) {
	$.widget('ui.sort', $.extend({}, $.ui.sortable.prototype, {

		options: {
			tabSize: 20,
			disableNesting: 'ui-sort-leaf',
			errorClass: 'ui-sort-error',
			listType: 'ul',
			maxLevels: 0,
			revertOnError: 1
		},

		_create: function() {
			this.element.data('sortable', this.element.data('ui-sort'));
			return $.ui.sortable.prototype._create.apply(this, arguments);
		},

		destroy: function() {
			this.element
				.removeData('ui-sort')
				.unbind('.ui-sort');
			return $.ui.sortable.prototype.destroy.apply(this, arguments);
		},

		_mouseDrag: function(event) {

			//Compute the helpers position
			this.position = this._generatePosition(event);
			this.positionAbs = this._convertPositionTo('absolute');

			if (!this.lastPositionAbs) {
				this.lastPositionAbs = this.positionAbs;
			}

			//Do scrolling
			if(this.options.scroll) {
				var o = this.options, scrolled = false;
				if(this.scrollParent[0] != document && this.scrollParent[0].tagName != 'HTML') {

					if((this.overflowOffset.top + this.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity)
						this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop + o.scrollSpeed;
					else if(event.pageY - this.overflowOffset.top < o.scrollSensitivity)
						this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop - o.scrollSpeed;

					if((this.overflowOffset.left + this.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity)
						this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft + o.scrollSpeed;
					else if(event.pageX - this.overflowOffset.left < o.scrollSensitivity)
						this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft - o.scrollSpeed;

				} else {

					if(event.pageY - $(document).scrollTop() < o.scrollSensitivity)
						scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
					else if($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity)
						scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);

					if(event.pageX - $(document).scrollLeft() < o.scrollSensitivity)
						scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
					else if($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity)
						scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);

				}

				if(scrolled !== false && $.ui.ddmanager && !o.dropBehaviour)
					$.ui.ddmanager.prepareOffsets(this, event);
			}

			//Regenerate the absolute position used for position checks
			this.positionAbs = this._convertPositionTo('absolute');

			//Set the helper position
			if(!this.options.axis || this.options.axis != 'y') this.helper[0].style.left = this.position.left+'px';
			if(!this.options.axis || this.options.axis != 'x') this.helper[0].style.top = this.position.top+'px';

			//Rearrange
			for (var i = this.items.length - 1; i >= 0; i--) {

				//Cache variables and intersection, continue if no intersection
				var item = this.items[i], itemElement = item.item[0], intersection = this._intersectsWithPointer(item);
				if (!intersection) continue;

				if(itemElement != this.currentItem[0] //cannot intersect with itself
					&&	this.placeholder[intersection == 1 ? 'next' : 'prev']()[0] != itemElement //no useless actions that have been done before
					&&	!$.contains(this.placeholder[0], itemElement) //no action if the item moved is the parent of the item checked
					&& (this.options.type == 'semi-dynamic' ? !$.contains(this.element[0], itemElement) : true)
					//&& itemElement.parentNode == this.placeholder[0].parentNode // only rearrange items within the same container
				) {

					$(itemElement).mouseenter();

					this.direction = intersection == 1 ? 'down' : 'up';

					if (this.options.tolerance == 'pointer' || this._intersectsWithSides(item)) {
						$(itemElement).mouseleave();
						this._rearrange(event, item);
					} else {
						break;
					}

					// Clear emtpy ul's/ol's
					this._clearEmpty(itemElement);

					this._trigger('change', event, this._uiHash());
					break;
				}
			}

			var parentItem = (this.placeholder[0].parentNode.parentNode
				       && $(this.placeholder[0].parentNode.parentNode).closest('.ui-sortable').length)
				       ? $(this.placeholder[0].parentNode.parentNode)
				       : null,
			    level = this._getLevel(this.placeholder),
			    childLevels = this._getChildLevels(this.helper),
			    previousItem = this.placeholder[0].previousSibling ? $(this.placeholder[0].previousSibling) : null;

			if (previousItem != null) {
				while (previousItem[0].nodeName.toLowerCase() != 'li' || previousItem[0] == this.currentItem[0]) {
					if (previousItem[0].previousSibling) {
						previousItem = $(previousItem[0].previousSibling);
					} else {
						previousItem = null;
						break;
					}
				}
			}

			newList = document.createElement(o.listType);

			this.beyondMaxLevels = 0;

			// If the item is moved to the left, send it to its parent level
			if (parentItem != null && this.positionAbs.left < parentItem.offset().left) {
				parentItem.after(this.placeholder[0]);
				this._clearEmpty(parentItem[0]);
				this._trigger('change', event, this._uiHash());
			}
			// If the item is below another one and is moved to the right, make it a children of it
			else if (previousItem != null && this.positionAbs.left > previousItem.offset().left + o.tabSize) {
				this._isAllowed(previousItem, level+childLevels+1);
				if (!previousItem.children(o.listType).length) {
					previousItem[0].appendChild(newList);
				}
				previousItem.children(o.listType)[0].appendChild(this.placeholder[0]);
				this._trigger('change', event, this._uiHash());
			}
			else {
				this._isAllowed(parentItem, level+childLevels);
			}

			//Post events to containers
			this._contactContainers(event);

			//Interconnect with droppables
			if($.ui.ddmanager) $.ui.ddmanager.drag(this, event);

			//Call callbacks
			this._trigger('sort', event, this._uiHash());

			this.lastPositionAbs = this.positionAbs;
			return false;

		},

		_mouseStop: function(event, noPropagation) {

			// If the item is in a position not allowed, send it back
			if (this.beyondMaxLevels) {

				this.placeholder.removeClass(this.options.errorClass);

				if (this.options.revertOnError) {
					if (this.domPosition.prev) {
						$(this.domPosition.prev).after(this.placeholder);
					} else {
						$(this.domPosition.parent).prepend(this.placeholder);
					}
					this._trigger('revert', event, this._uiHash());
				} else {
					var parent = this.placeholder.parent().closest(this.options.items);

					for (var i = this.beyondMaxLevels - 1; i > 0; i--) {
						parent = parent.parent().closest(this.options.items);
					}

					parent.after(this.placeholder);
					this._trigger('change', event, this._uiHash());
				}

			}

			// Clean last empty ul/ol
			for (var i = this.items.length - 1; i >= 0; i--) {
				var item = this.items[i].item[0];
				this._clearEmpty(item);
			}

			$.ui.sortable.prototype._mouseStop.apply(this, arguments);

		},

		serialize: function(o) {

			var items = this._getItemsAsjQuery(o && o.connected),
			    str = []; o = o || {};

			$(items).each(function() {
				var res = ($(o.item || this).attr(o.attribute || 'id') || '')
						.match(o.expression || (/(.+)[-=_](.+)/)),
				    pid = ($(o.item || this).parent(o.listType)
						.parent('li')
						.attr(o.attribute || 'id') || '')
						.match(o.expression || (/(.+)[-=_](.+)/));

				if (res) {
					str.push(((o.key || res[1]) + '[' + (o.key && o.expression ? res[1] : res[2]) + ']')
						+ '='
						+ (pid ? (o.key && o.expression ? pid[1] : pid[2]) : 'root'));
				}
			});

			if(!str.length && o.key) {
				str.push(o.key + '=');
			}

			return str.join('&');

		},

		toHierarchy: function(o) {
			o = o || {};
			var sDepth = o.startDepthCount || 0,
			    ret = [];

			$(this.element).children('li').each(function () {
				var level = _recursiveItems($(this));
				ret.push(level);
			});

			return ret;

			function _recursiveItems(li) {
				var id = ($(li).attr(o.attribute || 'id') || '').match(o.expression || (/(.+)[-=_](.+)/));
				if (id) {
					var item = {'id' : id.pop()};
					
					if(o.label) {
						item.label = $(o.label, li).html();
					}
					
					if ($(li).children(o.listType).children('li').length > 0) {
						item.children = [];
						$(li).children(o.listType).children('li').each(function() {
							var level = _recursiveItems($(this));
							item.children.push(level);
						});
					}
					return item;
				}
			}
		},

		toArray: function(o) {

			o = o || {};
			var sDepth = o.startDepthCount || 0,
			    ret = [],
			    left = 2;

			ret.push({
				'item_id': 'root',
				'parent_id': 'none',
				'depth': sDepth,
				'left': '1',
				'right': ($('li', this.element).length + 1) * 2
			});

			$(this.element).children('li').each(function () {
				left = _recursiveArray(this, sDepth + 1, left);
			});

			ret = ret.sort(function(a,b){ return (a.left - b.left); });

			return ret;

			function _recursiveArray(item, depth, left) {

				var right = left + 1,
				    id,
				    pid;

				if ($(item).children(o.listType).children('li').length > 0) {
					depth ++;
					$(item).children(o.listType).children('li').each(function () {
						right = _recursiveArray($(this), depth, right);
					});
					depth --;
				}

				id = ($(item).attr(o.attribute || 'id')).match(o.expression || (/(.+)[-=_](.+)/));

				if (depth === sDepth + 1) {
					pid = 'root';
				} else {
					var parentItem = ($(item).parent(o.listType)
						.parent('li')
						.attr(o.attribute || 'id'))
						.match(o.expression || (/(.+)[-=_](.+)/));
					pid = parentItem.pop();
				}

				if (id) {
					var data = {'item_id': id.pop(), 'parent_id': pid, 'depth': depth, 'left': left, 'right': right}
					if(o.label) {
						data.label = $(o.label, item).html();
					}
					ret.push(data);
				}

				left = right + 1;
				return left;
			}

		},

		_clearEmpty: function(item) {

			var emptyList = $(item).children(this.options.listType);
			if (emptyList.length && !emptyList.children().length) {
				emptyList.remove();
			}

		},

		_getLevel: function(item) {

			var level = 1;

			if (this.options.listType) {
				var list = item.closest(this.options.listType);
				while (!list.is('.ui-sortable')) {
					level++;
					list = list.parent().closest(this.options.listType);
				}
			}

			return level;
		},

		_getChildLevels: function(parent, depth) {
			var self = this,
			    o = this.options,
			    result = 0;
			depth = depth || 0;

			$(parent).children(o.listType).children(o.items).each(function (index, child) {
					result = Math.max(self._getChildLevels(child, depth + 1), result);
			});

			return depth ? result + 1 : result;
		},

		_isAllowed: function(parentItem, levels) {
			var o = this.options;
			// Are we trying to nest under a no-nest or are we nesting too deep?
			if (parentItem == null || !(parentItem.hasClass(o.disableNesting))) {
				if (o.maxLevels < levels && o.maxLevels != 0) {
					this.placeholder.addClass(o.errorClass);
					this.beyondMaxLevels = levels - o.maxLevels;
				} else {
					this.placeholder.removeClass(o.errorClass);
					this.beyondMaxLevels = 0;
				}
			} else {
				this.placeholder.addClass(o.errorClass);
				if (o.maxLevels < levels && o.maxLevels != 0) {
					this.beyondMaxLevels = levels - o.maxLevels;
				} else {
					this.beyondMaxLevels = 1;
				}
			}
			
			if(typeof o.isAllowed == 'function') {
				this.beyondMaxLevels = o.isAllowed.call(this, this.beyondMaxLevels, parentItem) ? 0 : 1;
			}
		}
	}));

	$.ui.sort.prototype.options = $.extend({}, $.ui.sortable.prototype.options, $.ui.sort.prototype.options);
	
	var uuid = 1;
	
	$.fn.extend({
		tree: function(types, options) {
			$(this).each(function() {
				var root = $('ul.eve-block-tree-root', this).sort({
					forcePlaceholderSize: true,
					handle: 'div',
					helper:	'clone',
					items: 'li',
					opacity: .6,
					placeholder: 'eve-block-tree-placeholder ui-state-highlight',
					revert: 250,
					tabSize: 25,
					tolerance: 'pointer',
					toleranceElement: '> div',
					disableNesting: 'eve-block-tree-leaf',
					errorClass: 'eve-block-tree-error ui-state-error',
					isAllowed: function(error, parent) {
						if(error) {
							return false;
						}
						
						var type = $('a.eve-block-tree-label', this.currentItem).attr('rel');
						var accept = types[$('a.eve-block-tree-label', parent).attr('rel')].accept;
						for(var i=0; i < accept.length; i++) {
							if(type == accept[i]) {
								return true;
							}
						}
						
						this.placeholder.addClass('eve-block-tree-error ui-state-error');
						return false;
					}
				});
				
				var self 		= $(this),
									
					head		= $('div.eve-block-tree-head', self),
					body		= $('div.eve-block-tree-body', self),
					clone		= $('ul.eve-block-tree-clone', self),
				
					action		= $('span.eve-block-tree-action', head),
					remove		= $('span.eve-block-tree-action-remove', head),
					add			= $('span.eve-block-tree-action-add', head),
					edit		= $('span.eve-block-tree-action-edit', head),
					save		= $('span.eve-block-tree-action-save', head),
					cancel		= $('span.eve-block-tree-action-cancel', head),
					
					item 		= 'div.eve-block-tree-item',
					icon 		= 'span.eve-block-tree-icon',
					label 		= 'a.eve-block-tree-label',
					field 		= 'input.eve-block-tree-field',
					
					disabled 	= 'ui-state-disabled',
					highlight 	= 'ui-state-highlight',
					active 		= 'ui-state-active';
				
				action.hover(function() {
					if(!$(this).hasClass(disabled)) {
						$(this).addClass('ui-state-hover');
					}
				}, function() {
					$(this).removeClass('ui-state-hover');
				});
				
				edit.click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					var selected = $(label+'.'+highlight, body).each(function() {
						$(this).hide().next().show();
					}).parent().parent();
					
					add.addClass(disabled);
					edit.addClass(disabled);
					remove.addClass(disabled);
					save.removeClass(disabled);
					cancel.removeClass(disabled);
					
					var list = root.sort('toArray', {listType: 'ul', attribute:'title', expression:/^.+$/});
					var tree = root.sort('toHierarchy', {listType: 'ul', attribute:'title', expression:/^.+$/});
					
					self.trigger('ui-tree-edit', {items:  selected, list: list, tree: tree});
					
					return false;
				});
				
				cancel.click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					var item = $(label+'.'+highlight, body).each(function() {
						var value = $(this).html();
						$(this).removeClass(highlight).show().next().val(value).hide();
					}).parent().parent();
					
					$('li.ui-tree-new', body).remove();
					
					edit.addClass(disabled);
					remove.addClass(disabled);
					save.addClass(disabled);
					cancel.addClass(disabled);
					
					var list = root.sort('toArray', {listType: 'ul', attribute:'title', expression:/^.+$/});
					var tree = root.sort('toHierarchy', {listType: 'ul', attribute:'title', expression:/^.+$/});
					
					self.trigger('ui-tree-cancel', {items: item, list: list, tree: tree});
					
					return false;
				});
				
				save.click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					var item = $(label+'.'+highlight, body).each(function() {
						var value = $(this).next().val();
						$(this).removeClass(highlight).html(value).css('display', 'block').next().hide();
					}).parent().parent().removeClass('eve-block-tree-new');
					
					edit.addClass(disabled);
					remove.addClass(disabled);
					save.addClass(disabled);
					cancel.addClass(disabled);
					
					var list = root.sort('toArray', {listType: 'ul', label: label, attribute:'title', expression:/^.+$/});
					var tree = root.sort('toHierarchy', {listType: 'ul', label: label, attribute:'title', expression:/^.+$/});

					self.trigger('ui-tree-save', {items: item, list: list, tree: tree});
					
					return false;
				});
				
				remove.click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					edit.addClass(disabled);
					remove.addClass(disabled);
					add.addClass(disabled);
					
					var item = $(label+'.'+highlight, self).parent().parent().remove();
					var list = root.sort('toArray', {listType: 'ul', attribute:'title', expression:/^.+$/});
					var tree = root.sort('toHierarchy', {listType: 'ul', attribute:'title', expression:/^.+$/});
					
					self.trigger('ui-tree-remove', {items: item, list: list, tree: tree});
					return false;
				});
				
				add.click(function(e) {
					e.preventDefault();
					if($(this).hasClass(disabled)) {
						return false;
					}
					
					var item = $('a.ui-state-highlight', self).parent().parent();
					
					if(item.hasClass('eve-block-tree-leaf')) {
						return false;
					}
					
					var type = $('a', this).attr('rel');
					var copy = $('li.'+type, clone).clone().attr('title', 'eve-block-tree-new'+(uuid++));
					
					$('a.eve-block-tree-label', copy).addClass(highlight).hide().next().css('display', 'inline-block');
					
					var list = $(item).children('ul');
					
					if(list.size() == 0) {
						list = $('<ul>').appendTo(item);
					}
					
					list.append(copy);
					
					add.addClass(disabled);
					edit.addClass(disabled);
					remove.addClass(disabled);
					save.removeClass(disabled);
					cancel.removeClass(disabled);
					
					return false;
				});
				
				$(label, body).live('mouseover', function() {
					$(this).addClass(active);
				});
				
				$(label, body).live('mouseout', function() {
					$(this).removeClass(active);
				});
				
				$(label, body).live('click', function(e) {
					e.preventDefault();	
					
					$(label+'.'+highlight, body).each(function() {
						var value = $(this).html();
						$(this).show().next().val(value).hide();
					})
					
					if(e.ctrlKey || e.metaKey) {
						$(this).toggleClass(highlight);
					} else if(e.shiftKey) {
						var $this = $(this).parent().parent();
						do {
							$(label, $this).addClass(highlight);
							if($this.prev().find(label+'.'+highlight).size() > 0) {
								break;
							}
							
							$this = $this.prev();
						} while($this.hasClass('eve-block-tree-branch') || $this.hasClass('eve-block-tree-leaf'));
					} else if($(this).hasClass(highlight)) {
						$(label, body).removeClass(highlight);
						$(this).removeClass(highlight);
					} else {
						$(label, body).removeClass(highlight);
						$(this).addClass(highlight);
					}
					
					var selected = $(label+'.'+highlight, body).size();
					
					if(selected > 1) {
						edit.removeClass(disabled);
						remove.removeClass(disabled);
						
						cancel.addClass(disabled);
						save.addClass(disabled);	
						add.addClass(disabled);
					} else if(selected == 1) {
						var node = $(label+'.'+highlight, body);
						if(!node.parent().parent().hasClass('eve-block-tree-leaf')) {
							add.each(function() {
								var type = $('a', this).attr('rel');
								for(var i=0; i < types[node.attr('rel')].accept.length; i++) {
									if(type == types[node.attr('rel')].accept[i]) {
										$(this).removeClass(disabled);
										return;
									}
								}
								
								$(this).addClass(disabled);
							});
						} else {
							add.addClass(disabled);
						}
						
						edit.removeClass(disabled);
						remove.removeClass(disabled);
						
						cancel.addClass(disabled);
						save.addClass(disabled);
					} else {
						remove.addClass(disabled);			
						add.addClass(disabled);
						edit.addClass(disabled);
						
						cancel.addClass(disabled);
						save.addClass(disabled);
					}
					
					$('li.ui-tree-new', body).remove();
					
					var item = $(label+'.'+highlight, body).parent().parent();
					var list = root.sort('toArray', {listType: 'ul', attribute:'title', expression:/^.+$/});
					var tree = root.sort('toHierarchy', {listType: 'ul', attribute:'title', expression:/^.+$/});
					
					self.trigger('ui-tree-select', {items: item, list: list, tree: tree});
					
					return false;
				});
				
				$(icon, body).live('click', function(e) {
					var $this = $(this);
					var type = types[$this.next().attr('rel')];
					
					if(!type.open) {
						return;
					}
					
					if(type.open == type.close) {
						var children = $this.parent().parent().children('ul');
						
						if(children.css('display') != 'none') {
							$this.removeClass(type.open);
							$this.addClass(type.close);
							$this.parent().parent().
								children('ul').hide().
								find(label+'.'+highlight).
								removeClass(highlight);
							
							self.trigger('ui-tree-branch-open', { branch: $this.parent().parent() });
						} else {
							$this.removeClass(type.close);
							$this.addClass(type.open);
							$this.parent().parent().children('ul').show();
							
							self.trigger('ui-tree-branch-close', { branch: $this.parent().parent() });
						}
						
					} else if($this.hasClass(type.open)) {
						$this.removeClass(type.open);
						$this.addClass(type.close);
						$this.parent().parent().
							children('ul').hide().
							find(label+'.'+highlight).
							removeClass(highlight);
						
						self.trigger('ui-tree-branch-open', { branch: $this.parent().parent() });
					} else if($this.hasClass(type.close)) {
						$this.removeClass(type.close);
						$this.addClass(type.open);
						$this.parent().parent().children('ul').show();
						
						self.trigger('ui-tree-branch-close', { branch: $this.parent().parent() });
					}
				});
			});
		}
	});
})(jQuery);