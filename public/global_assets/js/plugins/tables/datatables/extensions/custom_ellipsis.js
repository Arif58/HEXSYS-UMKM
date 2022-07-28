//custom https://datatables.net/plug-ins/dataRender/ellipsis

$.fn.dataTable.render.custom_ellipsis = function (start, length, mode) {
    return function (data, type, row) {

        switch (mode) {
            case 'substr':
                return data.substr(start, length);
                break;
            default:
                return data.substr(0, 5);
                break;
        }
    }
};

//{ data: 'no_rm', name:'no_rm', visible:true, render: $.fn.dataTable.render.custom_ellipsis(2,6,'substr') }, 