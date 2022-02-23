<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-dark bg-success py-2">
    <div class="container">
        <a class="navbar-brand mr-lg-5" href="{{base_url()}}">
            <img src="{{base_url('assets')}}/img/brand/kl_logo_small.jpg">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
            aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{base_url()}}">
                            <img src="{{base_url('assets')}}/img/brand/main_logo.jpg">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global"
                            aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                {{if $smarty.session.privilege >0}}
                    <li class="nav-item nav-link">
                        <i class="bi bi-person-circle"></i>
                        {{$allschool[$smarty.session.schoolid].schoolfullname}}
                        {{$smarty.session.realname}}
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
                            <i class="bi bi-gear"></i>
                            <span class="nav-link-inner--text">管理</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{base_url('/admin/user/view')}}/{{$smarty.session.user_id}}" class="dropdown-item"><i class="bi bi-person-badge"></i> 個人資料</a>
                            <a href="{{base_url()}}" class="dropdown-item"><i class="bi bi-clipboard-data"></i> 學校填報情形</a>
                            {{if $smarty.session.privilege>1}}
                            <a href="{{base_url('/admin/user/list')}}" class="dropdown-item border-top"><i class="bi bi-people"></i> 使用者管理</a>
                            <a href="{{base_url('/admin/school/list')}}" class="dropdown-item"><i class="bi bi-building"></i> 學校管理</a>
                            <a href="{{base_url('/admin/itemmanager/list')}}" class="dropdown-item"><i class="bi bi-calendar-check"></i> 參訪展館場次管理</a>
                            {{/if}}
                            {{if $smarty.session.privilege>2}}
                                <a href="{{base_url('/admin/param/list')}}" class="dropdown-item border-top"><i class="bi bi-tools"></i> 系統參數</a>
                            {{/if}}
                        </div>
                    </li>
                {{else}}
                    <li class="nav-item nav-link">
                        <i class="bi bi-person-circle"></i>
                        訪客
                    </li>
                {{/if}}
            </ul>

            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{base_url()}}" data-toggle="tooltip" title="首頁">
                        <i class="bi bi-house"></i>
                        <span class="nav-link-inner--text">首頁</span>
                    </a>
                </li>
                {{if $smarty.session.privilege > 0}}
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{base_url('/admin')}}" data-toggle="tooltip" title="填報">
                            <i class="bi bi-pencil-square"></i>
                            <span class="nav-link-inner--text">填報</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{base_url('/auth/logout')}}" data-toggle="tooltip"
                            title="登出">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="nav-link-inner--text">登出</span>
                        </a>
                    </li>
                {{else}}
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{base_url('/auth')}}" data-toggle="tooltip" title="使用者登入">
                            <i class="bi bi-person-square"></i>
                            <span class="nav-link-inner--text">登入</span>
                        </a>
                    </li>
                {{/if}}
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->