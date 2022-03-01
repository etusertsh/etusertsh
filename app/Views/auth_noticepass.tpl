<section class="section section-shaped section-lg">
    <div class="container pt-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-secondary shadow border">
                    <div class="card-header">
                        <h3>請變更密碼</h3>
                    </div>
                    <div class="card-body">
                        <p>您所使用的為預設密碼，為資訊安全考量，請您變更所使用之密碼！如不變更密碼，可以點選 <a href="{{base_url('/admin')}}" class="btn btn-info">此點</a> 進入填報介面！</p>
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <form class="form" action="{{base_url('/auth/noticeset')}}" method="POST" accept-charset="UTF-8">
                            <div class="form-group mb-3">
                                <label>新密碼</label>
                                <input type="password" class="form-control" name="pw" value="" placeholder="新密碼（六碼以上）" pattern=".{6,}" required autocomplete="off">
                            </div>
                            <div class="form-group mb-3">
                                <div class="g-recaptcha" data-sitekey="6Lf3nw0cAAAAAHF5dBY_S1Q3dSON8DVRPGKtBwnA">
                                </div>
                            </div>                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">變更密碼</button>
                                {{csrf_field()}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                    