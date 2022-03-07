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
                                    <th>日期</th>
                                    <th>場次</th>
                                    <th>填報情形</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{foreach key=key item=item from=$data}}
                                    {{foreach key=key2 item=item2 from=$item}}
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$actiontime.$key2.title}}</td>
                                        <td>
                                        {{$itemcount = array()}}
                                        {{foreach item=item3 from=$item2}}
                                            <span class="badge badge-{{cycle values='primary,success,info,warning'}} mx-1 mb-2">{{$allschool[$item3.schoolid].schoolname}}：{{$item3.itemcode}} ({{$item3.num}})</span>
                                            {{$itemcount[$item3.itemcode] = $itemcount[$item3.itemcode] + $item3.num}}
                                        {{/foreach}}
                                    <p>{{foreach key=key4 item=item4 from=$itemcount}}（{{$key4}}：{{$item4}}）  {{/foreach}}</p>
                                        </td>
                                    </tr>
                                    {{/foreach}}
                                {{/foreach}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>