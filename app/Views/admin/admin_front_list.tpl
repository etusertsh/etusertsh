<div class="row">
	{{$var = 8 - $smarty.now|date_format:"%w"}}
    <div class="col-sm-12 alert alert-info rounded shadow">
        <p class="h6">因需於一週前回報海科館相關參訪人次，故僅可填報 {{$var}} 日後場次。<br>請點選欲填報的日期，於填報區中填入預計參訪的人數，點選送出即可。</p>
    </div>
    <div class="col-md-9 col-sm-12">
        <div class="row my-2">
            <div class="col-3 mb-3">
                <div class="card bg-primary rounded shadow">
                    <div class="card-body text-center text-white h5 m-0">星期二</div>
                </div>
            </div>
            <div class="col-3 mb-3">
                <div class="card bg-primary rounded shadow">
                    <div class="card-body text-center text-white h5 m-0">星期三</div>
                </div>
            </div>
            <div class="col-3 mb-3">
                <div class="card bg-primary rounded shadow">
                    <div class="card-body text-center text-white h5 m-0">星期四</div>
                </div>
            </div>
            <div class="col-3 mb-3">
                <div class="card bg-primary rounded shadow">
                    <div class="card-body text-center text-white h5 m-0">星期五</div>
                </div>
            </div>
			
            {{$limitdate = "+$var days"|strtotime|date_format:"%Y%m%d"}}
            {{$preweek=''}}
            {{foreach item=item from=$actiondays}}
                {{$plandate = $item|date_format:"%Y%m%d"}}
                {{$planweek = $item|date_format:"%w"}}
                {{if $plandate > $limitdate}}
                    {{if $planweek == '2' && ($preweek < 5 && $preweek != '')}}
                        <div class="col-3 mb-1"></div>
                    {{/if}}
                    <div class="col-3 mb-1{{if $preweek == ''}} offset-{{($planweek-2)*3}}{{/if}}">
                    <div class="card border rounded shadow-lg{{if $itemdata[$item]['remain']=='0'}} bg-info{{/if}}" id="card_{{$item}}">
                            <div class="card-body text-center text-info p-2" id="card-body_{{$item}}">
                                <a href="#signup" value="{{$item|date_format:'%m/%d'}}" class="btn btn-info rounded mb-1"
                                    onclick="selectdate('{{$item}}');">{{$item|date_format:'%m/%d'}}</a><br>
                                剩餘：<span class="badge badge-success mb-1"
                                    id="remain_{{$item}}">{{$itemdata[$item].remain}}</span><br>已填：<span
                                    class="badge badge-primary mb-1"
                                    id="booking_{{$item}}">{{$bookingdata[$item].num|default: '0'}}</span>
                            </div>
                        </div>
                    </div>
                    {{$preweek = $planweek}}
                {{/if}}
            {{/foreach}}
        </div>
    </div>
    <div class="col-md-3 col-sm-12" id="signup">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card bg-warning rounded">
                    <div class="card-body text-center text-white h5 m-0">填報區</div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border rounded shadow">
                    <div class="card-body">
                        <form class="form" action="{{base_url('/booking/update')}}/{{$schoolid}}" method="post"
                            accept-charset="utf-8">
                            <label class="form-label h5">日期</label>
                            <input type="date" id="viewdate" name="itemdate" value="" required class="form-control"
                                onclick="return false;">
                            <label class="form-label h5 mt-3">上限：<span id="limitnum"
                                    class="text-danger">200</span></label><br>
                            <label class="form-label h5 mt-3">參訪人數</label>
                            <input type="number" id="num" name="num" step="1" min="0" max="200" value=""
                                class="form-control text-primary text-center fw-bold" required readonly="readonly"
                                style="font-size: 13pt;">
                            <button type="submit" class="btn btn-lg btn-warning rounded shadow mt-3 mx-auto">送出</button>
                            <input type="hidden" name="schoolid" value="{{$schoolid}}">
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let nowdate = '';

    let selectdate = function(thedate) {
        nowdate = thedate;
        $("#viewdate").val(thedate);
        bookingnum = parseInt($('#booking_' + thedate).text());
        limitnum = parseInt($('#remain_' + thedate).text()) + bookingnum;
        $('#limitnum').text(limitnum);
        $('#limitnum').html(limitnum);
        $('#num').val(bookingnum);
        $('#num').attr('max', limitnum);
        $('#num').attr('readonly', false);
        renew();
        setInterval(renew, 5000);
    };

    let renew = function() {
        $.ajax({
            url: "{{base_url('/ajaxfunc/renew')}}/{{$schoolid}}",
            dateType: "json",
            success: function(data) {
                data = jQuery.parseJSON(data);
                if (data.msg == "ok") {
                    showdata(data);
                }
            }
        });
    };
    let showdata = function(data){
        $(".badge-success").each(function(){
            thedate = $(this).attr('id').split('_')[1];
            if(data.booking[thedate]){
                $("#booking_" + thedate).text(data.booking[thedate].num);
                $("#booking_" + thedate).html(data.booking[thedate].num);
            }else{
                $("#booking_" + thedate).text('0');
                $("#booking_" + thedate).html('0');
            }            
        });
        $.each(data.itemdata, function(i, item){            
            if($("#remain_" + i).length){
                $("#remain_" + i).text(item.remain); 
                $("#remain_" + i).html(item.remain);               
                if(item.remain == '0'){
                    $("#card_" + i).addClass('bg-info');
                }else{
                    $("#card_" + i).removeClass("bg-info");
                }
            }
        });
        if(nowdate != ''){
            bookingnum = parseInt($('#booking_' + nowdate).text());
            limitnum = parseInt($('#remain_' + nowdate).text()) + bookingnum;
            $('#limitnum').text(limitnum);
            $('#limitnum').html(limitnum);
            $('#num').attr('max', limitnum);
            $('#num').attr('readonly', false);
        }
    };
    /*window.onload = function() {
            setInterval(renew, 10000);
    };*/
</script>