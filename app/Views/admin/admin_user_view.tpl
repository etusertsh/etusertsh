<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-secondary shadow border">
                    <div class="card-header pb-5">
                        <h5>{{$allschool[$data.schoolid].schoolfullname}} {{$data.realname}}</h5>
                        {{if $data.profile_pic != ''}}
                        <div class="text-right"><img src="{{$data.profile_pic}}" class="img-thumbnail rounded shadow border border-light" style="margin-top: -100px;"></div>
                        {{/if}}
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        {{if $smarty.session.privilege>1}}
                            <a href="{{base_url('/admin/user/list')}}" class="btn btn-primary rounded shadow">返回列表</a>
                        {{/if}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>