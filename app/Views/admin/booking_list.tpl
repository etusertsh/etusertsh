<section class="section section-shaped section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h4 text-primary mb-2">{{$allschool[$schoolid].schoolfullname}} <i class="bi bi-building"></i>
                    <a href="{{base_url('/booking/status')}}/{{$schoolid}}"
                        class="btn btn-lg btn-secondary border border-default"><i class="bi bi-search"></i>
                        檢視填報情形</a>
                </p>
                <p class="border border-default bg-secondary rounded p-3">共有 <span class="badge badge-primary">
                        {{$limitdata.limitnum|default: '0'}} </span> 車，已填報 <span id="schoolused"
                        class="badge badge-dark">{{$limitdata.used|default: '0'}}</span> 車，剩餘 <span id="schoolremain"
                        class="badge badge-warning">{{$limitdata.remain|default: '0'}}</span> 車需填報。</p>
            </div>
        </div>
        <h4 class="text-dark mb-3"><i class="bi bi-calendar-check"></i> {{$itemdate}} {{$actiontime.$itemtime.title}}
        </h4>
        <p class="text-right"><a href="#selectdatetime" class="btn btn-primary">選擇其他場次</a></p>
        <div class="row mb-3">
            {{foreach item=item from=$data}}
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card border border-default rounded shadow" id="card-{{$item.itemcode}}">
                        <div id="card-header-{{$item.itemcode}}" class="card-header{{if $item.remain > 0}} bg-success{{else}} bg-secondary{{/if}}"
                            id="card-header-{{$item.itemcode}}">
                            {{if $item.itemtype=='M'}}<span class="badge badge-primary">組合行程</span>{{/if}}
                            <p class="h4">{{$item.itemplace}}</p>
                        </div>
                        <div class="card-body">
                            <p class="text-right">剩餘：<strong class="h5 text-danger"
                                    id="remain-{{$item.itemcode}}">{{$item.remain}}</strong></p>
                            <p class="text-primary">{{$item.description}}</p>
                        </div>
                        <div class="card-footer">
                            <p>Booking：<span class="h3"
                                    id="booking-{{$item.itemcode}}">{{$schoolbooking[$item.itemcode].num|default:'-'}}</span>
                            </p>
                            <p class="text-right">
                                <button id="minusbtn-{{$item.itemcode}}" type="button" class="btn btn-danger mb-2"
                                    onclick="tominus('{{$item.itemcode}}');"
                                    style="display: {{if $schoolbooking[$item.itemcode].num > 0}}inline{{else}}none{{/if}};">－1</button>
                                <button id="plusbtn-{{$item.itemcode}}" type="button" class="btn btn-primary mx-2 mb-2"
                                    onclick="toplus('{{$item.itemcode}}');"
                                    style="display: {{if $limitdata.remain > 0 && $item.remain >0}}inline{{else}}none{{/if}};">＋1</button>
                                <span class="badge badge-warning" id="full-{{$item.itemcode}}"
                                    style="display: {{if $item.remain<=0}}inline{{else}}none{{/if}};">已額滿</span>
                                <span class="badge badge-info" id="runout-{{$item.itemcode}}"
                                    style="display: {{if $limitdata.remain<=0}}inline{{else}}none{{/if}};">已無可用車輛單位</span>
                            </p>
                        </div>
                    </div>
                </div>
            {{/foreach}}
        </div>
        <h4 class="text-primary"><i class="bi bi-calendar-event"></i> 選擇場次</h4>
        <div class="row" id="selectdatetime">
            {{foreach item=item from=$actiondays}}
                <div class="col-lg-3 col-md-4 col-sm-6 text-center mb-2">
                    <div class="card border rounded shadow">
                        <div class="card-body">
                            <h5 class="text-info">{{$item.date}}</h5>
                            {{foreach item=item2 from=$item.time}}
                                {{if !($item.date == $itemdate && $item2 == $itemtime)}}
                                    <a href="{{base_url('/booking/list')}}/{{$schoolid}}/{{$item.date}}/{{$item2}}"
                                        class="btn btn-{{if $item2=='AM'}}primary{{else}}success{{/if}} mb-2">{{$actiontime[$item2].title}}</a>
                                {{/if}}
                            {{/foreach}}
                        </div>
                    </div>
                </div>
            {{/foreach}}
        </div>
    </div>
    </div>
    <script>
        let toplus = function(code) {
            if (code != '') {
                $.ajax({
                    url: "{{base_url('/ajaxfunc/bookplus')}}/{{$schoolid}}/{{$itemdate}}/{{$itemtime}}/" + code,
                    dataType: "json",
                    success: function(data) {
                        //console.log(data);
                        if (data.msg == 'ok') {
                            showdata(data);
                        }
                    }
                });
            }
        };
        let tominus = function(code){
            if (code != '') {
                $.ajax({
                    url: "{{base_url('/ajaxfunc/bookminus')}}/{{$schoolid}}/{{$itemdate}}/{{$itemtime}}/" + code,
                    dataType: "json",
                    success: function(data) {
                        //console.log(data);
                        if (data.msg == 'ok') {
                            showdata(data);
                        }
                    }
                });
            }
        };
        let showdata = function(data) {
            $('#schoolused').text(data.limitdata.used);
            $('#schoolremain').text(data.limitdata.remain);
            $.each(data.itemdata, function(i, item) {
                thecode = item.itemcode;
                if(item.remain>0){
                    $('#card-header-' + thecode).removeClass('bg-secondary');
                    $('#card-header-' + thecode).addClass('bg-success');
                    $('#plusbtn-' + thecode).css('display','inline');
                    $('#full-' + thecode).css('display','none');
                }else{
                    $('#card-header-' + thecode).removeClass('bg-success');
                    $('#card-header-' + thecode).addClass('bg-secondary');
                    $('#plusbtn-' + thecode).css('display','none');
                    $('#full-' + thecode).css('display','inline');
                }
                if (thecode in data.booking) {
                    $('#booking-' + thecode).text(data.booking[thecode].num);
                    $('#minusbtn-' + thecode).css('display','inline');
                } else {
                    $('#booking-' + thecode).text('-');
                    $('#minusbtn-' + thecode).css('display','none');
                }
                if(data.limitdata.remain<=0){
                    $('#plusbtn-' + thecode).css('display','none');
                    $('#runout-' + thecode).css('display','inline');
                }else{
                    $('#runout-' + thecode).css('display','none');
                    if(item.remain>0){
                        $('#plusbtn-' + thecode).css('display','inline');
                    }else{
                        $('#plusbtn-' + thecode).css('display','none');
                    }
                }
                $('#remain-' + thecode).text(item.remain);
            });
        };
        let renew = function(){
            $.ajax({
                url: "{{base_url('/ajaxfunc/renew')}}/{{$schoolid}}/{{$itemdate}}/{{$itemtime}}",
                dataType: "json",
                success: function(data) {
                    //console.log(data);
                    if (data.msg == 'ok') {
                        showdata(data);
                    }
                }
            });
        };

        window.onload = function(){
            setInterval(renew,5000);
        };
</script>