<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-dark bg-success py-2">
    <div class="container">
        <a class="navbar-brand mr-lg-5" href="{base_url()}">
            <img src="{base_url('assets')}/img/brand/kl_logo_small.jpg">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
            aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{base_url()}">
                            <img src="{base_url('assets')}/img/brand/main_logo.jpg">
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
            {if $smarty.session.privilege >0}
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                    <li class="nav-item nav-link">
                        <i class="bi bi-person-circle"></i>
                        {$allschool[$smarty.session.schoolid].schoolname}
                        {$smarty.session.realname}
                    </li>
                </ul>
            {/if}
            <!--
    <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
      <li class="nav-item dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
          <i class="ni ni-ui-04"></i>
          <span class="nav-link-inner--text">Components</span>
        </a>
        <div class="dropdown-menu dropdown-menu-xl">
          <div class="dropdown-menu-inner">
            <a href="https://demos.creative-tim.com/argon-design-system/docs/getting-started/overview.html" class="media d-flex align-items-center">
              <div class="icon icon-shape bg-gradient-primary rounded-circle text-white">
                <i class="ni ni-spaceship"></i>
              </div>
              <div class="media-body ml-3">
                <h6 class="heading text-primary mb-md-1">Getting started</h6>
                <p class="description d-none d-md-inline-block mb-0">Learn how to use compiling Scss, change brand colors and more.</p>
              </div>
            </a>
            <a href="https://demos.creative-tim.com/argon-design-system/docs/foundation/colors.html" class="media d-flex align-items-center">
              <div class="icon icon-shape bg-gradient-success rounded-circle text-white">
                <i class="ni ni-palette"></i>
              </div>
              <div class="media-body ml-3">
                <h6 class="heading text-primary mb-md-1">Foundation</h6>
                <p class="description d-none d-md-inline-block mb-0">Learn more about colors, typography, icons and the grid system we used for .</p>
              </div>
            </a>
            <a href="https://demos.creative-tim.com/argon-design-system/docs/components/alerts.html" class="media d-flex align-items-center">
              <div class="icon icon-shape bg-gradient-warning rounded-circle text-white">
                <i class="ni ni-ui-04"></i>
              </div>
              <div class="media-body ml-3">
                <h5 class="heading text-warning mb-md-1">Components</h5>
                <p class="description d-none d-md-inline-block mb-0">Browse our 50 beautiful handcrafted components offered in the Free version.</p>
              </div>
            </a>
          </div>
        </div>
      </li>      
    </ul>-->
            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{base_url()}" data-toggle="tooltip" title="首頁">
                        <i class="bi bi-house"></i>
                        <span class="nav-link-inner--text">首頁</span>
                    </a>
                </li>
                {if $smarty.session.privilege > 0}
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{base_url('/admin')}" data-toggle="tooltip" title="填報">
                            <i class="bi bi-pencil-square"></i>
                            <span class="nav-link-inner--text">填報</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{base_url('/auth/logout')}" data-toggle="tooltip"
                            title="登出">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="nav-link-inner--text">登出</span>
                        </a>
                    </li>
                {else}
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{base_url('/auth')}" data-toggle="tooltip" title="使用者登入">
                            <i class="bi bi-person-square"></i>
                            <span class="nav-link-inner--text">登入</span>
                        </a>
                    </li>
                {/if}
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->