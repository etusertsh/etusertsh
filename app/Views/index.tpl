{{include file='index_header.tpl'}}
<div class="section section-hero section-shaped" style="background: url({{base_url('assets/img')}}/wave-bg.png) no-repeat center 110%;">
    <div class="page-header">
        <div class="container shape-container d-flex align-items-center py-lg">
            <div class="col px-0">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="{{base_url('assets')}}/img/brand/main_logo.jpg">
                        <h1 class="display-2">{{$nowparam.actionyear}}{{$nowparam.sitetitle}}</h1>
                        <div class="btn-wrapper mt-4">
                            {{if $smarty.session.privilege > 0}}
                                <a href="{{base_url('/admin')}}"
                                    class="btn btn-primary btn-icon mt-3 mb-sm-0">
                                    <span class="btn-inner--icon"><i class="bi bi-pencil"></i></span>
                                    <span class="btn-inner--text">填報</span>
                                </a>
                            {{else}}
                                <a href="{{base_url('/auth')}}"
                                    class="btn btn-warning btn-icon mt-3 mb-sm-0">
                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                    <span class="btn-inner--text">登入</span>
                                </a>
                            {{/if}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section features-6">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="info info-horizontal info-hover-primary">
                    <div class="description pl-4">
                        <h5 class="title"><i class="bi bi-calendar-event"></i> 活動日期</h5>
                        <div class="row">
                            {{foreach item=item from=$actiondays}}
                                <div class="col h5 text-success">{{$item.date|date_format:"%m/%d"}}</div>
                            {{/foreach}}
                        </div>
                    </div>
                </div>
                <div class="info info-horizontal info-hover-primary mt-5">
                    <div class="description pl-4">
                        <h5 class="title"><i class="bi bi-clock"></i> 活動場次</h5>
                        <div class="row">
                            {{foreach item=item from=$actiontime}}
                                <div class="col h5 text-info">{{$item.title}}：{{$item.time}}</div>
                            {{/foreach}}
                        </div>
                    </div>
                </div>
                <div class="info info-horizontal info-hover-primary mt-5">
                    <div class="description pl-4">
                        <h5 class="title"><i class="bi bi-geo-alt"></i> 參訪地點</h5>
                        <div class="row">
                            {{foreach item=item from=$actionplace}}
                                <div class="col-4 mb-3"><span class="fw-bold text-primary h5">{{$item.name}}</span><br>{{$item.description}}</div>
                            {{/foreach}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-10 mx-md-auto">
                <img class="ml-lg-5" src="{{base_url('assets')}}/img/ill/ill.png" width="100%">
            </div>
        </div>
    </div>
</div>
{{include file='index_footer.tpl'}}