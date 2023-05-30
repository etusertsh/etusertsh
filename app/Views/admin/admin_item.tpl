<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col">
                <p class="h5 text-primary">{{$pagetitle}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>序號</th>
                            <th>日期</th>
                            <th>人次上限</th>
                            <th>已填報人數</th>
                            <th>剩餘人數</th>
							<th>明細</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{foreach item=item from=$actiondays}}
                            <tr class="h6 text-center">
                                <td>{{counter}}</td>
                                <td>{{$item}}</td>
                                <td class="text-primary">{{$data[$item].limitnum}}</td>
                                <td class="text-danger">{{$data[$item].booking}}</td>
                                <td class="text-success">{{$data[$item].remain}}</td>
								<td>{{if $data[$item].booking > 0}}<a href="{{base_url('/booking/datetimestat')}}/{{$item}}"><i class="bi bi-search"></i></a>{{/if}}</td>
                            </tr>
                        {{/foreach}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>