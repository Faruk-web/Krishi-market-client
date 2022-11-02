<a href="{{ route('compare') }}" class="d-flex align-items-center text-reset">
    <i class="la la-refresh la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">
        @if(Session::has('compare'))
            <span style=" background: #93c353;color: white;" class="badge  badge-inline badge-pill">{{ count(Session::get('compare'))}}</span>
        @else
            <span style=" background: #93c353;color: white;" class="badge  badge-inline badge-pill">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Compare')}}</span>
    </span>
</a>