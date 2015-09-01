

function selectUpdate(id, data) {
    var item = $(id);
    item.empty();

    $.each(data, function(key, value) {
        item.append("<option value='"+ value +"'>" + key + "</option>");
    });
    item.trigger('change');
}

