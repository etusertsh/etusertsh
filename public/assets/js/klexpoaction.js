let toplus = function (code) {
    if (code != '') {
        $.ajax({
            url: "{{base_url('/ajaxfunc/bookplus')}}/{{$schoolid}}/{{$itemdate}}/{{$itemtime}}/" + code,
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.msg == 'ok') {
                    showdata(data);
                }
            }
        });
    }
};
let showdata = function (data) {
    $('#schoolused').text(data.limitdata.used);
    $('#schoolremain').text(data.limitdata.remain);
    $.each(data.itemdata, function (i, item) {
        thecode = item.itemcode;
        if (thecode in data.booking) {
            console.log(thecode);
            $('#booking-' + thecode).text(data.booking[thecode].num);
        } else {
            $('#booking-' + thecode).text('-');
        }
        $('#remain-' + thecode).text(item.remain);
    });
};