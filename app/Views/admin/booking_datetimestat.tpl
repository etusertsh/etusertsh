<section class="section section-shaped section-lg">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-8 mb-3">
                <p class="h4 text-center">{{$pagetitle}}</p>
            </div>
            <div class="col-sm-4 mb-3 d-print-none">
                <form name="form1" class="form" action="{{base_url('/booking/datetimestat')}}" method="post"
                    accept-charset="utf-8">
                    <label class="h5 text-priamry">選擇日期</label>
                    <select name="itemdate" class="form-control" required
                        onchange="if(this.selectedIndex>0){ document.form1.submit();}">
                        <option value=""></option>
                        {{foreach item=item from=$actiondays}}
                            <option value="{{$item}}" {{if $item == $itemdate}} selected{{/if}}>{{$item}}</option>
                        {{/foreach}}
                    </select>
                </form>
            </div>
            <div class="col-sm-10 mx-auto">
                <div class="card border border-light rounded shadow-lg" style="min-height: 50vh;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover h5">
                                <thead>
                                    <tr>
                                        <th>學校名稱</th>
                                        <th>參訪人數</th>
                                        <th>教師</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{foreach item=item from=$data}}
                                        <tr>
                                            <td>{{$allschool[$item.schoolid].schoolfullname}}</td>
                                            <td>{{$item.num}}</td>
                                            <th>{{$item.teacher}}</td>
                                        </tr>
                                    {{/foreach}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>