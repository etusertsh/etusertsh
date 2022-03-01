<section class="section section-shaped section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h4 text-primary mb-2">{{$allschool[$schoolid].schoolfullname}} <i class="bi bi-building"></i>
                    <a href="" class="btn btn-lg btn-secondary border border-default"><i class="bi bi-search"></i>
                        檢視填報情形</a>
                </p>
                <p class="border border-default bg-secondary rounded p-3">共有 <span class="badge badge-primary">
                        {{$limitdata.limitnum|default: '0'}} </span> 車，已填報 <span
                        class="badge badge-dark">{{$limitdata.userd|default: '0'}}</span> 車，剩餘 <span
                        class="badge badge-warning">{{$limitdata.remain|default: '0'}}</span> 車需填報。</p>
            </div>
        </div>
        <h4 class="text-dark mb-3">填報：{{$itemdate}} {{$actiontime.$itemtime.title}}</h4>
        <p class="text-right"><a href="#selectdatetime" class="btn btn-primary">選擇其他場次</a></p>
        <div class="row mb-3">
            {{foreach item=item from=$data}}
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card border border-default rounded shadow">
                        <div class="card-header">
                            {{if $item.itemtype=='M'}}<span class="badge badge-primary">組合行程</span>{{/if}}
                            <p class="h4">{{$item.itemplace}}</p>
                        </div>
                        <div class="card-body">
                            <p class="text-right">剩餘：<strong class="h5 text-danger">{{$item.remain}}</strong></p>
                            <p class="text-primary">{{$item.description}}</p>
                        </div>
                    </div>
                </div>
            {{/foreach}}
        </div>
        <h4 class="text-primary">選擇場次</h4>
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