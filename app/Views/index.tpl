{{include file='index_header.tpl'}}
<div class="section section-hero section-shaped" style="background: url({{$nowparam.front_banner}}) no-repeat center bottom;">
    <div class="page-header">
        <div class="container shape-container d-flex align-items-center py-lg">
            <div class="col px-0">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="{{base_url('assets')}}/img/brand/main_logo.jpg">
                        <h1 class="display-2">{{$nowparam.actionyear}}<br>{{$nowparam.sitetitle}}</h1>
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
{{include file='index_intro.tpl'}}
{{include file='index_footer.tpl'}}