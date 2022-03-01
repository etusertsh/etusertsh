<section class="section section-shaped section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mb-3">
                <p class="h4 mb-2">{{$allschool[$schoolid].schoolfullname}} {{$pagetitle}}</p>
            </div>
            <div class="card border col-sm-12">
                <div class="card-body">
                    <p class="border border-default bg-secondary rounded p-3">共有 <span class="badge badge-primary">
                            {{$limitdata.limitnum|default: '0'}} </span> 車，已填報 <span id="schoolused"
                            class="badge badge-dark">{{$limitdata.used|default: '0'}}</span> 車，剩餘 <span
                            id="schoolremain" class="badge badge-warning">{{$limitdata.remain|default: '0'}}</span>
                        車需填報。</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>場次</th>
                                    <th>參訪展館</th>
                                    <th>說明</th>
                                    <th nowrap>填報車數</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            {{foreach item=item from=$data}}
                                <tr>
                                    <td nowrap>{{$item.itemdate}}</td>
                                    <td nowrap>{{$actiontime[$item.itemtime].title}}</td>
                                    <td class="text-primary" nowrap>{{$item.itemplace.itemplace}}
                                    <a href="{{base_url('/booking/list')}}/{{$schoolid}}/{{$item.itemdate}}/{{$item.itemtime}}" class="btn btn-info mx-2">繼續填報</a></td>
                                    <td>{{$item.itemplace.description}}</td>
                                    <td class="text-danger h4">{{$item.num}}</td>
                                    <td></td>
                                </tr>
                            {{/foreach}}
                            </tbody>
                        </table>
                    </div>
                </div>
</section>