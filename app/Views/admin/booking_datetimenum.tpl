<section class="section section-shaped section-lg">
    <div class="container-fluid">
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
                                    {{foreach item=item from=$rowitem}}
                                        <th class="text-center">{{$item.itemplace}}</th>
                                    {{/foreach}}
                                </tr>
                            </thead>
                            <tbody>
                                {{foreach item=item from=$actiondays}}
                                    {{foreach item=item2 from=$item.time}}
                                        <tr>
                                            <td>{{$item.date|date_format:'%m/%d'}}</td>
                                            <td>{{$actiontime[$item2].title}}</td>
                                            {{foreach key=key item=item3 from=$rowitem}}
                                                {{$num = $data[$item.date].$item2.$key}}
                                                {{if $key == 'D'}}
                                                    {{$people = $num * 20}}
                                                {{else}}
                                                    {{$people = $num * 30}}
                                                {{/if}}
                                                <td class="text-center">
                                                    {{if $num > 0}}
                                                        {{$num}} ({{$people}})
                                                    {{/if}}
                                                    </td>
                                                {{/foreach}}
                                            </tr>
                                        {{/foreach}}
                                    {{/foreach}}
                                </tbody>
                            </table>
                            <p class="text-right text-info"><small>統計時間：{{$smarty.now|date_format:'%Y-%m-%d %H:%M'}}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>