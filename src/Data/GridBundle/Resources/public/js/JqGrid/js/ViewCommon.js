function stickHeaderWhileScrolling() {
    var elements = $('div.ui-jqgrid-hdiv');
    if (elements.length == 0) {
        return
    }
    var predecessor = $(".ui-jqgrid-titlebar");
    var frozenElement = elements.get(0);
    frozenElement = $(frozenElement).css("z-index", 200);
    var table = frozenElement.closest("table.ui-jqgrid-btable");
    sticker = frozenElement.clone().css({
        visibility: "hidden"
    });
    frozenElement.after(sticker);
    var frozenElemHeight = frozenElement.outerHeight();
    var predecessorBottom = predecessor.css("top");
    var frozenElemLeft = frozenElement.offset().left;
    table.bind("resize.reportstickyheaders", _.throttle(adjustLeft, 50));
    $(window).off(".reportstickyheaders");
    $(window).on("scroll.reportstickyheaders", _.throttle(adjustStuckElement, 50));
    $(window).on("resize.reportstickyheaders", _.throttle(adjustElementWidths, 150));
    $(window).on("updateStickyHeaders.reportstickyheaders", updateStickyHeaders);
    adjustStuckElement();

    function adjustStuckElement() {
        var isStuck = frozenElement.hasClass("StickyHeader");
        var predecessorBottomOffset = predecessor.offset().top + predecessor.outerHeight();
        var shouldStick = ((isStuck ? sticker : frozenElement).offset().top <= predecessorBottomOffset);
        shouldStick = shouldStick && (table.offset().top + table.outerHeight() - predecessorBottomOffset >= frozenElemHeight);
        if (shouldStick) {
            frozenElement.css("left", (frozenElemLeft - $(window).scrollLeft()) + "px")
        }
        if (shouldStick && !isStuck) {
            var elementHeight = (isStuck ? sticker : frozenElement).outerHeight();
            sticker.css("height", elementHeight + "px").show();
            frozenElement.width(sticker.width());
            frozenElement.find("td").each(function () {
                var t = $(this);
                t.width(t.outerWidth())
            });
            frozenElement.addClass("StickyHeader");
            predecessorBottom = predecessor.css("top");
            var matches = predecessorBottom.match(/(\d+)/);
            predecessorBottom = (matches && matches.length) ? matches[0] : 0;
            predecessorBottom = predecessor.outerHeight() + parseInt(predecessorBottom);
            frozenElement.css({
                top: predecessorBottom + "px"
            })
        } else {
            if (!shouldStick) {
                sticker.css("height", "1px").hide();
                frozenElement.removeClass("StickyHeader").css("top", "")
            }
        }
    }

    function adjustElementWidths() {
        var isStuck = frozenElement.hasClass("StickyHeader");
        if (isStuck) {
            var refRow = table.children("tbody").children(".jqgrow").first();
            if (refRow.length > 0) {
                var nextRowTds = refRow.find("td");
                var col = 0;
                frozenElement.width(refRow.width());
                frozenElement.find("td").each(function () {
                    var t = $(this);
                    t.width($(nextRowTds[col]).outerWidth());
                    ++col
                })
            }
            var predecessorBottomNew = predecessor.css("top");
            var matches = predecessorBottomNew.match(/(\d+)/);
            predecessorBottomNew = (matches && matches.length) ? matches[0] : 0;
            predecessorBottomNew = predecessor.outerHeight() + parseInt(predecessorBottomNew);
            if (predecessorBottomNew != predecessorBottom) {
                frozenElement.css({
                    top: predecessorBottomNew + "px"
                });
                predecessorBottom = predecessorBottomNew
            }
        }
    }

    function updateStickyHeaders() {
        sticker.remove();
        sticker = frozenElement.clone().css({
            visibility: "hidden"
        }).removeClass("StickyHeader");
        var isStuck = frozenElement.hasClass("StickyHeader");
        frozenElement.after(sticker);
        if (!isStuck) {
            sticker.css("height", "1px").hide()
        }
        adjustElementWidths()
    }

    function adjustLeft() {
        var isStuck = frozenElement.hasClass("StickyHeader");
        var offsetLeft = (isStuck ? sticker : frozenElement).offset().left;
        if (frozenElemLeft != offsetLeft) {
            frozenElemLeft = offsetLeft;
            frozenElement.css("left", (frozenElemLeft - $(window).scrollLeft()) + "px")
        }
    }
}
/*global jQuery 
(function ($) {
$.extend($.fn.fmatter , {
RESTfulLink : function(cellvalue, options, rowdata)
{
var opts = options.colModel.formatoptions.url;
if(typeof opts == 'string')
{
return '<a href="'+opts + cellvalue+'">'+cellvalue+'</a>';
}else{
return cellvalue;
}
}
});
$.extend($.fn.fmatter, {
    dateFmatter: function(cellvalue, options, rowObject) {
  if (cellvalue) {
    return $.jgrid.parseDate(
      'ISO8601Long',
      cellvalue.date,
      'ShortDate',
      $.extend({}, $.jgrid.formatter.date, options)
      );
  } else {
    return '---';
  }
}
});
$.extend($.fn.fmatter.dateFmatter, {
  unformat: function(cellvalue, options) {
    var a = $.map(cellvalue.split(/[^0-9]/), function(s) { return parseInt(s, 10) });
    return new Date(a[0], a[1]-1 || 0, a[2] || 1, a[3] || 0, a[4] || 0, a[5] || 0, a[6] || 0);
  }
});
}(jQuery));*/
