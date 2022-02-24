<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h5 text-primary">{{$pagetitle}}</p>
                <a href="{{base_url('/admin/itemmanager/list')}}" class="btn btn-success">返回日期場次選擇</a>
            </div>
        </div>
        <form class="form mb-3" action="{{base_url('/admin/itemmanager/batchadd')}}/{{$itemdate}}/{{$itemtime}}"
            method="post" accept-charset="utf-8">
            <div class="form-group">
                <label>批次新增場次</label>
                <input type="text" name="addstr" class="form-control" value="A D B C K BC CK BK">
                <button class="btn btn-primary" type="submit">新增</button>
                {{csrf_field()}}
            </div>
            <div class="form-group">
                {{foreach key=key item=item from=$actionplace}}
                    <span class="badge badge-light mx-2">{{$key}}：{{$item.name}}</span>
                {{/foreach}}
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <form class="form mb-3" action="{{base_url('/admin/itemmanager/update')}}/{{$itemdate}}/{{$itemtime}}"
                    method="post" accept-charset="utf-8">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>類型</th>
                                <th>系統編號</th>
                                <th>展館</th>
                                <th>場地</th>
                                <th>單位容量</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{foreach item=item from=$data}}
                                <tr>
                                    <td>{{if $item.itemtype == 'M'}}<span class="badge badge-info">組合行程</span>{{/if}}</td>
                                    <td>{{$item.itemcode}}</td>
                                    <td>{{$item.itemplace}}</td>
                                    <td>{{$item.description}}</td>
                                    <td>{{$item.limitnum}}</td>
                                    <td><a href="{{base_url('/admin/itemmanager/delete')}}/{{$itemdate}}/{{$itemtime}}/{{$item.id}}" class="btn btn-danger btn-icon"><i
                                                class="bi bi-trash"></i></a></td>
                                </tr>
                            {{/foreach}}
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>