<section class="section section-shaped section-lg">
    <div class="container pt-lg-3">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h4 text-primary mb-2">{{$allschool[$schoolid].schoolfullname}} <i class="bi bi-building"></i>
                <a href="" class="btn btn-lg btn-secondary border border-default"><i class="bi bi-search"></i> 檢視填報情形</a>
                </p>
                <p class="border border-default bg-secondary rounded p-3">共有 <span class="badge badge-primary"> {{$limitdata.limitnum|default: '0'}} </span> 車，已填報 <span class="badge badge-dark">{{$limitdata.userd|default: '0'}}</span> 車，剩餘 <span class="badge badge-warning">{{$limitdata.remain|default: '0'}}</span> 車需填報。</p> 
            </div>
        </div>
        <h4>選擇日期場次 <i class="bi bi-calendar"></i></h4>
        <div class="row">
            {{foreach item=item from=$actiondays}}
                <div class="col-md-6 col-lg-4 p-2 mb-3">
                    <div class="card border border-light rounded shadow">
                        <div class="card-header">
                            <p class="h5 text-primary">{{$item.date|date_format:'%Y-%m-%d <span class="text-info">(%a)</span>'}}</p>
                        </div>
                        <div class="card-body">
                            {{foreach key=key2 item=item2 from=$actiontime}}
                                {{if in_array($key2, $item.time)}}
                                <a href="{{base_url('/booking/book')}}/{{$schoolid}}/{{$item.date}}/{{$key2}}" class="btn btn-lg btn-{{if $key2=='AM'}}success{{else}}primary{{/if}} border border-default mx-2 mb-3">{{$item2.title}} ({{$item2.time}})</a>
                                {{else}}
                                <button type="button" class="btn btn-lg btn-secondary mx-2 mb-2">{{$item2.title}} (不開放)</button>
                                {{/if}}
                            {{/foreach}}
                        </div>
                    </div>
                </div>
            {{/foreach}}
        </div>
    </div>
</section>