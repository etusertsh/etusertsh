<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card bg-secondary shadow border">
                    <div class="card-header pb-2">
                        <h5>使用者管理</h5>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-hover" data-toggle="table"
                                data-search="true" data-show-columns="true" data-pagination="true">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>權限</th>
                                        <th>學校/單位</th>
                                        <th>姓名</th>
                                        <th>電子郵件</th>
                                        <th>辦公室電話</th>
                                        <th>手機號碼</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{foreach item=item from=$data}}
                                        <tr>
                                            <td>{{if $item.profile_pic != ''}}<img src="{{$item.profile_pic}}"
                                                        class="rounded img-thumbnail border border-light" width="64"
                                                    alt="{$item.name}">{{/if}}</td>
                                            <td><span
                                                    class="badge badge-{{if $item.privilege == '1'}}primary{{elseif $item.privilege=='3'}}warning{{else}}success{{/if}}">{{$privilegetext[$item.privilege]}}</span>
                                            </td>
                                            <td>{{$allschool[$item.schoolid].schoolfullname}}</td>
                                            <td>{{$item.realname}}</td>
                                            <td>{{$item.email}}</td>
                                            <td>{{$item.officetel}}</td>
                                            <td>{{$item.mobile}}</td>
                                            <td>
                                                <button
                                                    onclick="self.location='{{base_url('/admin/user/view')}}/{{$item.id}}';"
                                                    class="btn btn-primary btn-icon"><i class="bi bi-pencil"></i></button>
                                                <button
                                                    onclick="if(confirm('確定刪除使用者？一旦刪除將無法恢復！')){self.location='{{base_url('/admin/user/delete')}}/{{$item.id}}';}"
                                                    class="btn btn-danger btn-icon"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    {{/foreach}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card bg-white shadow border mt-3">
                    <div class="card-header pb-2">
                        <h5>新增使用者</h5>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form class="form" action="{{base_url('/admin/user/addnew')}}" method="POST" accept-charset="utf-8">
                            <div class="form-group mb-3">
                                <label>學校/單位</label>
                                <select name="schoolid" class="form-control" required>
                                    <option value=""></option>
                                    {{foreach key=key item=item from=$allschool}}
                                        <option value="{{$key}}">{{$item.schooltype}} / {{$item.schoolfullname}}</option>
                                    {{/foreach}}
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>姓名</label>
                                <input type="text" name="realname" class="form-control" value="" placeholder="新使用者姓名" required autocomplete="off">
                            </div>
                            <div class="form-group mb-3">
                                <label>電子郵件</label>
                                <input type="email" name="email" class="form-control" value="" placeholder="新使用者電子郵件" required autocomplete="off">
                            </div>
                            <div class="form-group text-center">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary mx-2">確定</button>
                                <button type="reset" class="btn btn-secondary">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>