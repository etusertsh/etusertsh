<section class="section section-shaped section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mb-3">
                <p class="h4 mb-2">{{$pagetitle}}</p>
            </div>
            <div class="card border rounded shadow col-sm-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>學制</th>
                                    <th>學校名稱</th>
                                    <th>學校教師</th>
                                    <th class="text-center text-primary h5">填報人數</th>
                                    <th class="d-print-none"></th>
                                </tr>
                            </thead>
                            <tbody>
                            {{foreach key=key item=item from=$allschool}}
                            <tr>
                                    <td class="align-middle">{{$item.schooltype}}</td>
                                    <td class="text-primary align-middle">{{$item.schoolfullname}}</td>
                                    <td class="align-middle">
                                    {{foreach item=item from=$tdata[$item.schoolid]}}
                                    {{$item.realname}}{{if !$item@last}}, {{/if}}
                                    {{/foreach}}
                                    <td class="text-center text-primary h5">{{$data[$item.schoolid].num|default:'-'}}</td>
                                    <td class="d-print-none"><a href="{{base_url('/booking/status')}}/{{$key}}" class="btn btn-primary"><i class="bi bi-list"></i> 填報內容</a></td>
                                </tr>
                            {{/foreach}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>