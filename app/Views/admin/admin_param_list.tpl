<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-secondary shadow border">
                    <div class="card-header pb-2">
                        <h5>系統參數管理</h5>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form name="form1" class="form mb-3" action="{{base_url('/admin/param/update1')}}"
                            method="POST">
                            <div class="form-group mb-3">
                                <label>網站名稱</label>
                                <input type="text" name="sitetitle" class="form-control" value="{{$data.sitetitle}}"
                                    required>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col">
                                    <label>年度</label>
                                    <input name="actionyear" type="number" min="2022" step="1"
                                        value="{{$data.actionyear}}" required class="form-control">
                                </div>
                                <div class="col">
                                    <label>是否autoadduser</label>
                                    <select name="autoadduser" class="form-control" required>
                                        <option value="true" {{if $data.autoadduser==true}} selected{{/if}}>是</option>
                                        <option value="false" {{if $data.autoadduser == false}} selected{{/if}}>否
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col">
                                    <label>填報開放時間</label>
                                    <input type="date" name="begin_at" value="{{$data.begin_at}}" class="form-control"
                                        required>
                                </div>
                                <div class="col">
                                    <label>填報結束時間</label>
                                    <input type="date" name="end_at" value="{{$data.end_at}}" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">更新</button>
                                {{csrf_field()}}
                            </div>
                        </form>
                        <form class="form mb-3" name="form2" action="{{base_url('/admin/param/updateactiondays')}}"
                            method="POST">
                            <div class="form-group">
                                <label>參訪日期參數</label>
                                <textarea name="actiondays" class="form-control" rows="5"
                                    required>{{$data.actiondays}}</textarea>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">更新</button>
                                {{csrf_field()}}
                            </div>
                        </form>
                        <form class="form mb-3" name="form3" action="{{base_url('/admin/param/updateactiontime')}}"
                            method="POST">
                            <div class="form-group">
                                <label>參訪時間參數</label>
                                <textarea name="actiontime" class="form-control" rows="5"
                                    required>{{$data.actiontime}}</textarea>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">更新</button>
                                {{csrf_field()}}
                            </div>
                        </form>
                        <form class="form mb-3" name="form4" action="{{base_url('/admin/param/updateactionplace')}}"
                            method="POST">
                            <div class="form-group">
                                <label>參訪地點參數</label>
                                <textarea name="actionplace" class="form-control" rows="5"
                                    required>{{$data.actionplace}}</textarea>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">更新</button>
                                {{csrf_field()}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>