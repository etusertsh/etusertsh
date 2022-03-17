<section class="section section-shaped section-lg">
    <div class="container pt-lg-3">
        <div class="row justify-content-center mb-2">
            <div class="col">
                <p class="h4 text-primary mb-2">{{$allschool[$schoolid].schoolfullname}} <i class="bi bi-building"></i>
                    <a href="{{base_url('/booking/status')}}/{{$schoolid}}"
                        class="btn btn-lg btn-secondary border border-default"><i class="bi bi-search"></i> 檢視填報情形</a>
                </p>
                <p class="bg-secondary rounded p-3 h5 text-info border border-light rounded shadow">填報時間：{{$nowparam.begin_at}} ~ {{$nowparam.end_at}}</p>                
            </div>
        </div>
        <h4>選擇日期場次 <i class="bi bi-calendar-event"></i></h4>        
        {{$signable = ($smarty.now|date_format:'%Y%m%d' >= $nowparam.begin_at|date_format:'%Y%m%d' && $smarty.now|date_format:'%Y%m%d' <= $nowparam.end_at|date_format:'%Y%m%d') || $smarty.session.privilege > 1}}
        {{if $signable}}
            {{include file='admin/admin_front_list.tpl'}}
        {{else}}
            <div class="row">
                <div class="col-12 alert alert-warning rounded shadow">目前非填報開放時間</div>
            </div>
        {{/if}}
    </div>
</section>