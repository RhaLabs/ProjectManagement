
$(function stickHeaderWhileScrolling() {
    var elements = $("thead.sticky>.grid-row-titles");
    if (elements.length == 0) {
        return
    }
    var predecessor = $("#navbar");
    var frozenElement = elements.get(0);
    frozenElement = $(frozenElement).css("z-index", 200);
    var table = frozenElement.closest("table.table");
    sticker = frozenElement.clone().css({visibility: "hidden"});
    frozenElement.after(sticker);
    var frozenElemHeight = frozenElement.outerHeight();
    var predecessorBottom = predecessor.css("top");
    var frozenElemLeft = frozenElement.offset().left;
    table.bind("resize", adjustLeft);
    $(window).off(".reportstickyheaders");
    $(window).on("scroll", adjustStuckElement);
    $(window).on("resize", adjustElementWidths);
    $(window).on("updateStickyHeaders", updateStickyHeaders);
    adjustStuckElement();
    adjustElementWidths();
    function adjustStuckElement() {
        var isStuck = frozenElement.hasClass("stuckHeader");
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
            frozenElement.find("td").each(function() {
                var t = $(this);
                t.width(t.outerWidth())
            });
            frozenElement.addClass("stuckHeader");
            predecessorBottom = predecessor.css("top");
            var matches = predecessorBottom.match(/(\d+)/);
            predecessorBottom = (matches && matches.length) ? matches[0] : 0;
            predecessorBottom = predecessor.outerHeight() + parseInt(predecessorBottom);
            frozenElement.css({top: predecessorBottom + "px"})
        } else {
            if (!shouldStick) {
                sticker.css("height", "1px").hide();
                frozenElement.removeClass("stuckHeader").css("top", "")
            }
        }
    }
    function adjustElementWidths() {
        var isStuck = frozenElement.hasClass("stuckHeader");
        if (isStuck) {
            var refRow = table.children("tbody").children("tr").first();
            if (refRow.length > 0) {
                var nextRowTds = refRow.find("td");
                var col = 0;
                frozenElement.width(refRow.width());
                frozenElement.find("th").each(function() {
                    var t = $(this);
                    t.width($(nextRowTds[col]).outerWidth(true));
                    ++col
                })
            }
            var predecessorBottomNew = predecessor.css("top");
            var matches = predecessorBottomNew.match(/(\d+)/);
            predecessorBottomNew = (matches && matches.length) ? matches[0] : 0;
            predecessorBottomNew = predecessor.outerHeight() + parseInt(predecessorBottomNew);
            if (predecessorBottomNew != predecessorBottom) {
                frozenElement.css({top: predecessorBottomNew + "px"});
                predecessorBottom = predecessorBottomNew
            }
        }
    }
    function updateStickyHeaders() {
        sticker.remove();
        sticker = frozenElement.clone().css({visibility: "hidden"}).removeClass("stuckHeader");
        var isStuck = frozenElement.hasClass("stuckHeader");
        frozenElement.after(sticker);
        if (!isStuck) {
            sticker.css("height", "1px").hide()
        }
        adjustElementWidths()
    }
    function adjustLeft() {
        var isStuck = frozenElement.hasClass("stuckHeader");
        var offsetLeft = (isStuck ? sticker : frozenElement).offset().left;
        if (frozenElemLeft != offsetLeft) {
            frozenElemLeft = offsetLeft;
            frozenElement.css("left", (frozenElemLeft - $(window).scrollLeft()) + "px")
        }
    }
});
