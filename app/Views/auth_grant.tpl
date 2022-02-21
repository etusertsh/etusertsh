<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-secondary shadow border">
                    <div class="card-header pb-5">
                        <h3>使用者授權</h3>
                        <small>本系統須使用者授權保留您的帳號資料，並正確設定您的所屬學校/單位</small>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <form role="form" action="{base_url('/auth/togrant')}" method="POST" accept-charset="UTF-8">
                            <div class="form-group mb-3">
                                <h5>請核對您的資料</h5>
                                <p class="text-primary">電子郵件：{$smarty.session.email}<br>
                                姓名：{$smarty.session.realname}</p>
                            <div class="form-group mb-3">
                                <h5>請選擇您所屬的學校</h5>
                                <select name="newschoolid" class="form-control" required>
                                <option value=""></option>
                                {foreach key=key item=item from=$allschool}
                                <option value="{$key}"{if $key == $smarty.session.schoolid} selected{/if}>{$item.schooltype} / {$item.schoolfullname}</option>
                                {/foreach}
                                </select>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">確定授權</button>
                                <input type="hidden" name="useropenid" value="{{$smarty.session.openid}}">
                                {csrf_field()}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>