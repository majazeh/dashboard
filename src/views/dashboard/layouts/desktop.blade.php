<div id="desktop" class="d-none d-lg-block desktop justify-content-xl-center align-items-center align-items-sm-start">
    <div id="branding-title" class="branding branding-title d-none align-items-center px-3">
        <h2 class="text-white text-truncate mb-0">
            <a class="text-white" href="{{ env('APP_URL') }}">{{ _d('title') }}</a>
        </h2>
    </div>
    <div class="desktop-content py-3 px-3 w-100">
        <div class="d-flex flex-wrap flex-column align-content-center  justify-content-center mb-5">
            <div class="d-flex tile align-content-center justify-content-center">
                <div class="d-flex flex-column justify-content-center align-items-center w-50">
                    <span class="number">۰</span>
                    <span class="text">خالی</span>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center border-between w-50">
                    <span class="number">۳</span>
                    <span class="text">در حال انجام</span>
                </div>
            </div>
            <div class="pt-3 pb-2 border-top border-bottom tile-large">
                <div class="desktop-list">
                    <h3 class="desktop-list-title">
                        <i class="fas fa-list-ul"></i>
                        لیست  ابزارها
                    </h3>
                    <nav class="list-group">
                        <a href="#" class="list-group-item">هشدارها</a>
                        <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                    دکمه‌ها
                    <span class="badge badge-desktop badge-pill">جدید</span>
                </a>
                        <a href="#" class="list-group-item active">صفحه بندی</a>
                        <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                    نوار پیشرفت
                    <span class="badge badge-desktop">جدید</span>
                </a>
                        <a href="" class="list-group-item">فرم‌ها</a>
                    </nav>
                </div>
            </div>
            <div class="d-flex tile align-content-center justify-content-center">
                <div class="d-flex flex-column justify-content-center align-items-center w-50">
                    <span class="number">۷</span>
                    <span class="text">انجام شده</span>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center border-between w-50">
                    <span class="number">۵</span>
                    <span class="text">نمودارها</span>
                </div>
            </div>
            <div class="d-flex w-100 pt-4 pb-2 border-top border-bottom tile-large">
                <div class="desktop-progress w-100">
                    <h3 class="desktop-progress-title">میزان پیشرفت اسناد</h3>
                    <div class="w-100">
                        <div class="row progress-item">
                            <div class="col-7 progress-item-title"><span>ابزارک‌ها</span></div>
                            <div class="col-5 align-self-center progress-item-bar">
                                <div style="height: 2px;" class="progress progress-rounded">
                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row progress-item">
                            <div class="col-7 progress-item-title"><span>دکمه‌ها</span></div>
                            <div class="col-5 align-self-center progress-item-bar">
                                <div style="height: 2px;" class="progress progress-rounded">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row progress-item">
                            <div class="col-7 progress-item-title"><span>نوار پیشرفت</span></div>
                            <div class="col-5 align-self-center progress-item-bar">
                                <div style="height: 2px;" class="progress progress-rounded">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row progress-item">
                            <div class="col-7 progress-item-title"><span>صفحه بندی</span></div>
                            <div class="col-5 align-self-center progress-item-bar">
                                <div style="height: 2px;" class="progress progress-rounded">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>