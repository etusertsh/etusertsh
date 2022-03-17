<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h5 text-primary">{{$pagetitle}}</p>
                <a href="{{base_url('/admin/itemmanager/list')}}" class="btn btn-success">返回日期場次選擇</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form class="form mb-3" action=""
                    method="post" accept-charset="utf-8">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>展館</th>
                                <th>人次上限</th>
                                <th>已填報人數</th>
                                <th>剩餘人數</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{foreach item=item from=$actiondays}}
                                <tr>
                                    <td>{{$item}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            {{/foreach}}
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>