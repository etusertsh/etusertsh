<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-secondary shadow border">
                    <div class="card-header pb-2">
                        <h5>{{$allschool[$data.schoolid].schoolfullname}} {{$data.realname}} <span
                                class="badge badge-{{if $data.privilege == '1'}}primary{{elseif $data.privilege=='3'}}warning{{else}}success{{/if}}">{{$privilegetext[$data.privilege]}}</span>
                        </h5>
                        {{if $data.profile_pic != ''}}
                            <div class="text-right"><img src="{{$data.profile_pic}}"
                                    class="img-thumbnail rounded shadow border border-light" style="margin-top: -100px;">
                            </div>
                        {{/if}}
                    </div>
                    <div class="card-body px-lg-5 py-lg-5 bg-white">
                        {{if $smarty.session.privilege>1}}
                            <h5>僅管理權限可見</h5>
                            <a href="{{base_url('/admin/user/list')}}"
                                class="btn btn-primary rounded shadow mb-2">返回列表</a><br>
                            {{foreach key=key item=item from=$privilegetext}}
                                {{if $key != $data.privilege}}
                                    <a href="{{base_url("/admin/user/setprivilege_$key")}}/{{$data.id}}"
                                        class="btn btn-light mr-2 mb-2">設成「{{$item}}」</a>
                                {{/if}}
                            {{/foreach}}
                            <hr>
                        {{/if}}
                        <form class="form" action="{{base_url('/admin/user/update')}}/{{$data.id}}" method="POST"
                            accept-charset="utf-8">
                            <div class="form-group row mt-3">
                                <div class="col">
                                    {{if $smarty.session.privilege>1}}
                                        <label>學校/單位</label>
                                        <select name="schoolid" class="form-control" required>
                                            {{foreach key=key item=item from=$allschool}}
                                                <option value="{{$key}}" {{if $key == $data.schoolid}} selected{{/if}}>
                                                    {{$item.schooltype}} / {{$item.schoolfullname}}</option>
                                            {{/foreach}}
                                        </select>
                                    {{else}}
                                        學校/單位： {{$allschool[$data.schoolid].schooltype}} /
                                        {{$allschool[$data.schoolid].schoolfullname}}
                                    {{/if}}
                                </div>
                                <div class="col">
                                    <label>姓名</label>
                                    <input type="text" name="realname" value="{{$data.realname}}" class="form-control"
                                        required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                {{if $smarty.session.privilege >1}}
                                    <label>電子郵件</label>
                                    <input type="email" name="email" value="{{$data.email}}" class="form-control" required
                                        autocomplete="off">
                                {{else}}
                                    電子郵件： {{$data.email}}
                                {{/if}}
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col">
                                    <label>辦公室電話</label>
                                    <input type="tel" name="officetel" value="{{$data.officetel}}" autocomplete="off"
                                        class="form-control">
                                </div>
                                <div class="col">
                                    <label>手機號碼</label>
                                    <input type="tel" name="mobile" value="{{$data.mobile}}" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group mt-3 text-center">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$data.id}}">
                                <button type="submit" class="btn btn-primary">修改</button>
                            </div>
                            <div>
                                <p class="text-muted">無法修改的資訊請洽主辦單位修改</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>