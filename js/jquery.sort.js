/**** save order to database *****/
// $('#button').click(function(event){
//        var order = $("#sortlist").sortable("serialize");
//        $('#message').html('Saving changes..');
//        $.post("save.php",order,function(theResponse){
//                      $('#message').html(theResponse);
//                      });
//        event.preventDefault();
// });



/**** save in cookie ****/

// set the list selector
var setSelector = "#sortlistTwo";
// set the cookie name
var setCookieName = "listOrder";
// set the cookie expiry time (days):
var setCookieExpiry = 7;

// save actual order
function getOrder() {
    $.cookie(setCookieName, $(setSelector).sortable("toArray"), { expires: setCookieExpiry, path: "/" });
}

// restore saved order
function restoreOrder() {
    var list = $(setSelector);
    if (list == null) return

    var cookie = $.cookie(setCookieName);
    if (!cookie) return;

    var IDs = cookie.split(",");

    var items = list.sortable("toArray");

    var rebuild = [];
    for ( var v=0, len=items.length; v<len; v++){
        rebuild[items[v]] = items[v];
    }

    for (var i = 0, n = IDs.length; i < n; i++) {

        var itemID = IDs[i];

        if (itemID in rebuild) {

            // select item id from current order
            var item = rebuild[itemID];

            // select the item according to current order
            var child = $("ul" + setSelector + ".ui-sortable").children("#" + item);

            // select the item according to the saved order
            var savedOrd = $("ul" + setSelector + ".ui-sortable").children("#" + itemID);

            // remove all the items
            child.remove();

            // add the items in turn according to saved order
            $("ul" + setSelector + ".ui-sortable").append(savedOrd);
        }
    }
}


$(function() {
    // sort items
    $(setSelector).sortable({
        cursor: "move",
        update: function() { getOrder(); }
    });

    // restore saved order
    restoreOrder();
});