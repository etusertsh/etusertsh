<section class="section section-shaped section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mb-3">
                <p class="h4 mb-2">{{$pagetitle}}</p>
            </div>
            <div class="card border rounded shadow col-sm-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover h5">
                            <thead>
                                <tr>
                                    <th>學制</th>
                                    <th>學校名稱</th>
                                    <th class="text-primary">核定數</th>
                                    <th class="text-success">填報數</th>
                                    <th class="text-danger">剩餘</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            {{foreach key=key item=item from=$allschool}}
                            <tr{{if $limitdata.$key.remain<=0}} style="background: {{if $limitdata.$key.limitnum==0}}#EEE{{else}}#FFFFCC{{/if}};"{{/if}}>
                                    <td>{{$item.schooltype}}</td>
                                    <td>{{$item.schoolfullname}}</td>
                                    <td class="text-primary">{{$limitdata.$key.limitnum}}</td>
                                    <td class="text-success">{{$limitdata.$key.used}}</td>
                                    <td class="text-danger">{{$limitdata.$key.remain}}</td>
                                    <td><a href="{{base_url('/booking/status')}}/{{$key}}" class="btn btn-primary"><i class="bi bi-list"></i> 填報內容</a></td>
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