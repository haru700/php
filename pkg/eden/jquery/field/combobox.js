;/* Combobox */
(function(a){a.widget("ui.combobox",{_create:function(){var d=this,b=this.element.hide(),e=b.children(":selected"),f=e.val()?e.text():"";var c=this.input=a('<input name="'+b.attr("name")+'">').val(a(e).html()).insertAfter(b).autocomplete({delay:0,minLength:0,source:function(h,g){var i=new RegExp(a.ui.autocomplete.escapeRegex(h.term),"i");g(b.children("option").map(function(){var j=a(this).text();if(this.value&&(!h.term||i.test(j))){return{label:j.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+a.ui.autocomplete.escapeRegex(h.term)+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>"),value:j,option:this}}}))},select:function(g,h){h.item.option.selected=true;d._trigger("selected",g,{item:h.item.option})}}).addClass("text text-ui");c.data("autocomplete")._renderItem=function(g,h){return a("<li></li>").data("item.autocomplete",h).append("<a>"+h.label+"</a>").appendTo(g)};this.button=a("<button type='button'>&nbsp;</button>").attr("tabIndex",-1).attr("title","Show All Items").insertAfter(c).button({icons:{primary:"ui-icon-triangle-1-s"},text:false}).removeClass("ui-corner-all").addClass("ui-corner-right ui-button-icon").click(function(){if(c.autocomplete("widget").is(":visible")){c.autocomplete("close");return}c.autocomplete("search","");c.focus()})},destroy:function(){this.input.remove();this.button.remove();this.element.show();a.Widget.prototype.destroy.call(this)}})})(jQuery);