<div class="d-flex align-items-center navigation">
    @if (false)
        <div class="d-none d-md-block branding-title">
            <a class="font-weight-bold" href="{{ route('dashboard') }}" title="{{ _d('title.dashio') }}">
                {{ _d('title.dashio') }}
            </a>
        </div>
    @endif

    <div class="flex-grow-1 d-flex justify-content-between navigation-inner">
        <div class="d-flex align-items-center navigation-search">
            @section('search-field')
                <form>
                    <i class="fas fa-search"></i>
                    <input placeholder="{{ _d('Search') }}" title="{{ _d('Search') }}">
                </form>
            @show
        </div>

        <div class="d-flex align-items-center navigation-account">
            @if (\Auth::user())
                <a href="{{ route('dashboard.notifications.index') }}" class="navigation-notification">
                    <i class="fal fa-bell" data-value="10"></i>
                </a>
                <span class="navigation-profile-image" data-toggle="modal" data-target="#profileModal">
                    <img src="{{ asset('images/profile-image.jpg') }}" alt="{{ asset('images/profile-image.jpg') }}" width="32" height="32">
                </span>
                <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <a href="{{ route('users.edit', \Auth::id()) }}">
                                    {{ \Auth::user() ? \Auth::user()->name : '' }}
                                </a>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('logout') }}" method="post" class="w-100 direct">
                                    @csrf
                                    <button class="btn btn-danger btn-gradient btn-block">
                                        {{ _d('exit') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if (false)
                    <a class="d-none d-sm-block navigation-account-title" href="{{ route('users.edit', \Auth::id()) }}">
                        {{ \Auth::user() ? \Auth::user()->name : '' }}
                    </a>
                    <a href="{{ route('dashboard.notifications.index') }}" class="ml-1 border rounded-circle border-muted">
                        <span class="badge badge-pill badge-danger">10</span>
                        <i class="fal fa-bell p-2 text-muted"></i>
                    </a>
                    <a tabindex='0'
                    class='navigation-profile-image action'
                    role='button'
                    data-content='<div><form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-sm btn-danger btn-gradient action" data-method="post" href="{{ route('logout') }}" class="text-danger f2">خروج</button></form></div>'
                    data-toggle='popover'
                    data-html='true'
                    data-placement='bottom' href="javascript:return false">
                        <img src="{{ asset('images/profile-image.jpg') }}" alt="{{ \Auth::user()->name}}" width="40" height="40">
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>