<section class="section section-shaped section-lg">
    <div class="shape shape-style-1 bg-gradient-default">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="container pt-lg-7">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-white pb-5">
                        <div class="text-muted text-center mb-3"><small>本市學校承辦請使用 gm.kl.edu.tw 網域認證</small></div>
                        <div class="btn-wrapper text-center">
                            <a href="{{$data.google_login_url}}" class="btn btn-neutral btn-icon">
                                <img src="{{base_url('assets')}}/img/gm_oauth_btn48.png">
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>未有 gm.kl.edu.tw 之學校承辦請以下方電子郵件登入</small>
                        </div>
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <form role="form" action="{{base_url('/auth/login')}}" method="POST" accept-charset="UTF-8">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input name="a" class="form-control" placeholder="電子郵件" type="email" required>
                                </div>
                            </div>
                            <div class="form-group focused">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input name="b" class="form-control" placeholder="密碼" type="password" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="g-recaptcha" data-sitekey="6Lf3nw0cAAAAAHF5dBY_S1Q3dSON8DVRPGKtBwnA">
                                </div>
                            </div>                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">登入</button>
                                {{csrf_field()}}
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>