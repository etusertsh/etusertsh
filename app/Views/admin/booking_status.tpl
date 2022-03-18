<section class="section section-shaped section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mb-3">
                <p class="h4 mb-2">{{$allschool[$schoolid].schoolfullname}} {{$pagetitle}}</p>
            </div>
            <div class="card border-light rounded shadow-lg col-sm-12">
                <div class="card-body">                    
                    {{$signable = ($smarty.now|date_format:'%Y%m%d' >= $nowparam.begin_at|date_format:'%Y%m%d' && $smarty.now|date_format:'%Y%m%d' <= $nowparam.end_at|date_format:'%Y%m%d') || $smarty.session.privilege > 1}}
                    {{if $signable == true}}
                        <p class="text-right d-print-none">
                            <a href="{{base_url('/admin/index')}}/{{$schoolid}}" class="btn btn-primary rounded">繼續填報</a>
                        </p>
                    {{/if}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>場次</th>
                                    <th>參訪展館</th>
                                    <th nowrap>參訪人數</th>
                                    <th>填報教師</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{foreach item=item from=$data}}
                                    <tr>
                                        <td nowrap>{{$item.itemdate}}</td>
                                        <td nowrap>上午第一場次(9 時-11 時)</td>
                                        <td class="text-primary" nowrap>潮境智能海洋館</td>
                                        <td class="text-danger h4">{{$item.num}}</td>
                                        <td>{{$item.teacher}}</td>
                                        <td nowrap>
                                            {{if $signable}}
                                                <button type="button" class="btn btn-danger d-print-none" onclick="if(confirm('確定刪除本填報紀錄？一旦刪除將無法恢復，需重新填報！')){self.location='{{base_url('/booking/status')}}/{{$schoolid}}/delete/{{$item.id}}';}"><i class="bi bi-trash"></i></button>
                                            {{/if}}
                                        </td>
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