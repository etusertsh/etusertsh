<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h5 text-primary">{{$allschool[$smarty.session.schoolid].schoolfullname}}</p>
            </div>
        </div>
        <h4>選擇日期場次</h4>
        <div class="row">
            {{foreach item=item from=$actiondays}}
                <div class="col-md-6 col-lg-4 p-2 mb-3">
                    <div class="card border border-light rounded shadow">
                        <div class="card-header">
                            <p class="h5 text-primary">{{$item.date|date_format:"%m/%d"}}</p>
                        </div>
                        <div class="card-body">
                            {{foreach key=key2 item=item2 from=$actiontime}}
                                {{if in_array($key2, $item.time)}}
                                <a href="{{base_url('/booking/book')}}/{{$schoolid}}/{{$item.date}}/{{$key2}}" class="btn btn-lg btn-{{if $key2=='AM'}}success{{else}}primary{{/if}} border border-danger mx-2 mb-2">{{$item2.title}} ({{$item2.time}})</a>
                                {{else}}
                                <button type='button" class="btn btn-lg btn-secondary mx-2 mb-2">{{$item2.title}} (不開放)</button>
                                {{/if}}
                            {{/foreach}}
                        </div>
                    </div>
                </div>
            {{/foreach}}
        </div>
    </div>
</section>