<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="{{ route('dashboard') }}"
                            target="_blank">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg><span>Dashboard</span></a></li>

                    @if (auth()->check())
                        @php
                            $currentUser = auth()->user();
                        @endphp
                        {{-- ------Company----- --}}
                        <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg><span>Company </span></a>
                            <ul class="sidebar-submenu">

                                <li><a href="{{ route('company.index') }}">Company</a></li>
                                <li><a href="{{ route('department.index') }}">Department</a></li>
                                <li>
                                    <a href="{{ route('team.index') }}">Team</a>
                                </li>
                            </ul>
                        </li>
                        {{-- --------users --------- --}}
                        <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg><span>User </span></a>
                            <ul class="sidebar-submenu">

                                <li><a href="{{ route('users.index') }}">User</a></li>

                            </ul>
                        </li>
                        {{-- --------Cash Request Category --------- --}}
                        <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg><span>Cash Category </span></a>
                            <ul class="sidebar-submenu">

                                <li>
                                    <a href="{{ route('cash-category.index') }}">Cash Categories</a>
                                </li>
                                <li>
                                    <a href="{{ route('cash_requests.report') }}"> Reports</a>
                                </li>
                            </ul>
                        </li>

                        {{-- --------Cash Request--------- --}}
                        <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg><span>Cash Request </span></a>
                            <ul class="sidebar-submenu">

                                <li><a href="{{ route('cash_requests.index') }}">Cash Request</a></li>
                                @if (isset($currentUser->role) && $currentUser->role === 'gm')
                                    <li>
                                        <a href="{{ route('cash_requests.approved_by_department_head') }}">Cash Request
                                            GM</a>
                                    </li>
                                @endif
                                @if (isset($currentUser->role) && $currentUser->role === 'accounts' && $currentUser->is_manager)
                                    <li>
                                        <a href="{{ route('cash_requests.approved_by_accounts_head') }}">Cash Request
                                            Account</a>
                                    </li>
                                @endif
                            </ul>
                    @endif
                    {{-- --------HR--------- --}}
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                            </svg><span>HR </span></a>
                        <ul class="sidebar-submenu">

                            <li>
                                <a href="{{ route('employee-evaluation.index') }}">Employee Evaluation</a>
                            </li>

                            <li>
                                <a href="{{ route('annual-employee-evaluation.index') }}"> Annual Evaluation</a>
                            </li>

                            @if (auth()->user()->is_manager || in_array(auth()->user()->role, ['gm', 'hr']))
                                <li>
                                    <a href="{{ route('annual-employee-evaluation_by_gm.index') }}">Annual Evaluation
                                        by GM</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('pass-key.index') }}"> Pass Key</a>
                            </li>
                        </ul>
                    </li>
                    {{-- --------Project inquiry--------- --}}
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                            </svg><span>Project inquiry </span></a>
                        <ul class="sidebar-submenu">

                            <li>
                                <a href="{{ route('project_inquiry.index') }}">Project inquiry</a>
                            </li>

                            <li>
                                <a href="{{ route('forms.index') }}"> Forms</a>
                            </li>

                        </ul>
                    </li>
                    {{-- -------------Project------------ --}}
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"> </i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                        </svg><span>Project </span></a>
                    <ul class="sidebar-submenu">

                        <li>
                            <a href="{{ route('projects.index') }}"> Project</a>
                        </li>

                        <li>
                            <a href="{{ route('task.index') }}"> Task</a>
                        </li>

                    </ul>
                </li>
                    {{-- ----------------------------- --}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
