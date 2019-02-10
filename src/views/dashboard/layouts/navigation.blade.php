<div class="d-flex align-items-center navigation">
    <div class="d-none d-md-block px-2 branding-title">
        <a class="font-weight-bold" href="{{ env('APP_URL') }}" title="{{ _d('title.dashio') }}">
            {{ _d('title.dashio') }}
        </a>
    </div>

    <div class="flex-grow-1 d-flex justify-content-between px-2 navigation-inner">
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
            <a href="#" class="d-none navigation-notification">
                <i class="far fa-bell" data-value="۵"></i>
            </a>
            <a class="d-none d-sm-block navigation-account-title" href="{{ route('users.edit', \Auth::id()) }}">
                {{ \Auth::user() ? \Auth::user()->name : '' }}
            </a>
            <a href="{{route('dashboard.notifications.index')}}" class="ml-1 border rounded-circle border-muted">
                <span class="badge badge-pill badge-danger">10</span>
                <i class="fal fa-bell p-2 text-muted"></i>
            </a>
            <a tabindex='0'
             class='navigation-profile-image'
             role='button'
             data-content='<div><a class="btn btn-sm btn-danger btn-gradient" href="{{ route('logout') }}" class="text-danger f2">خروج</a></div>'
             data-toggle='popover'
             data-html='true'
             data-placement='bottom'>
                <img src="{{ asset('images/profile-image.jpg') }}" alt="{{ \Auth::user()->name}}" width="40" height="40">
            </a>
            @endif
        </div>
    </div>
</div>