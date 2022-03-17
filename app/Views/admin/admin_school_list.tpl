<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card bg-secondary shadow border">
                    <div class="card-header pb-2">
                        <h5>學校管理</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{base_url('/admin/school/update')}}" method="POST" accept-charset="utf-8">
                            <div class="table-responsive">
                                <table id="table" data-toggle="table" data-search="true" data-show-columns="true"
                                    data-pagination="true" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th data-searchable="false">啟用</th>
                                            <th>編號</th>
                                            <th>行政區</th>
                                            <th>學制</th>
                                            <th>學校名稱</th>
                                            <th>班級數</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{foreach item=item from=$data}}
                                            <tr id="schooltr-{{$item.id}}"
                                                class="{{if $item.available != '1'}}bg-secondary text-info{{/if}}">
                                                <td>
                                                    <input type="checkbox" role="switch" value="1"
                                                        {{if $item.available=='1'}} checked{{/if}}
                                                        onclick="schoolavailable(this, '{{$item.id}}');">
                                                </td>
                                                <td>{{$item.eduid}}</td>
                                                <td>{{$item.area}}</td>
                                                <td>{{$item.schooltype}}</td>
                                                <td>{{$item.schoolfullname}}</td>
                                                <td>{{if $item.available}}{{$item.classnum}}{{/if}}</td>
                                            </tr>
                                        {{/foreach}}
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
let schoolavailable = function(obj, id){
    trobj = document.getElementById('schooltr-'+id);
    if(obj.checked == ''){
        status ='0';
    }else{
        status='1';
    }
    $.ajax({
        url: "{{base_url('/ajaxfunc/schoolavailable')}}/" + id + "/" + status,
        success: function(data){
            res = data.split(',');
            if(res[0]=='ok'){
                if(status=='0'){
                    trobj.classList.add('bg-secondary');
                    trobj.classList.add('text-info');
                }else{
                    trobj.classList.remove('bg-secondary');
                    trobj.classList.remove('text-info');
                }
            }
        }
    });    
};    
</script>