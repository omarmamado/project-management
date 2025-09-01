<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{ url('/dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                @if(auth()->check())
                    @php
                        $currentUser = auth()->user();
                    @endphp

                    @if(isset($currentUser->role) && ($currentUser->role === 'hr' || $currentUser->role === 'gm'))
                        @if(isset($currentUser->is_manager) && $currentUser->is_manager)

                            <li>
                                <a href="#sidebarCrm" data-bs-toggle="collapse">
                                    <i class="mdi mdi-account-multiple-outline"></i>
                                    <span> Company </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarCrm">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('company.index') }}">Company</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('department.index') }}">Department</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('team.index') }}">Team</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#salary" data-bs-toggle="collapse">
                                    <i class="mdi mdi-email-multiple-outline"></i>
                                    <span> Users </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="salary">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('users.index') }}">User</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        @endif
                    @endif

                    <li>
                        <a href="#salary1" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Cash Request </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="salary1">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('cash_requests.index') }}">Cash Request</a>
                                </li>
                                @if(isset($currentUser->role) && $currentUser->role === 'gm')
                                <li>
                                    <a href="{{ route('cash_requests.approved_by_department_head') }}">Cash Request GM</a>
                                </li>
                            @endif
                            @if(isset($currentUser->role) && $currentUser->role === 'accounts' && $currentUser->is_manager)
                            <li>
                                <a href="{{ route('cash_requests.approved_by_accounts_head') }}">Cash Request Account</a>
                            </li>
                        @endif
                            </ul>
                        </div>
                    </li>

                    @if((auth()->user()->role === 'accounts' || auth()->user()->role === 'gm') && auth()->user()->is_manager)
    <li>
        <a href="#cash-category" data-bs-toggle="collapse">
            <i class="mdi mdi-cash-multiple"></i>
            <span> Cash Category </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="cash-category">
            <ul class="nav-second-level">
                <li>
                    <a href="{{ route('cash-category.index') }}">Cash Categories</a>
                </li>
                <li>
                    <a href="{{ route('cash_requests.report') }}"> Reports</a>
                </li>
            </ul>
        </div>
    </li>
@endif

                @endif

                <li>
                    <a href="#HR" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-multiple"></i>
                        <span> HR </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="HR">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('employee-evaluation.index') }}">Employee Evaluation</a>
                            </li>
                            
                            <li>
                                <a href="{{ route('annual-employee-evaluation.index') }}"> Annual Employee Evaluation</a>
                            </li>
                            
                            @if(auth()->user()->is_manager || in_array(auth()->user()->role, ['gm', 'hr']))
                            <li>
                                <a href="{{ route('annual-employee-evaluation_by_gm.index') }}">Annual Employee Evaluation by GM</a>
                            </li>
                        @endif
                            <li>
                                <a href="{{ route('pass-key.index') }}"> Pass Key</a>
                            </li>
                           
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#ProjectInquiry" data-bs-toggle="collapse">
                        <i class="mdi mdi-book-account-outline"></i>
                        <span> Project inquiry </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="ProjectInquiry">
                        <ul class="nav-second-level">
                             <li>
                                <a href="{{ route('forms.index') }}"> Forms</a>
                            </li> 
                            <li>
                                <a href="{{ route('project_inquiry.index') }}">Project Inquiry</a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#Project" data-bs-toggle="collapse">
                        <i class="mdi mdi-book-account-outline"></i>
                        <span> Project  </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Project">
                        <ul class="nav-second-level">
                             <li>
                                <a href="{{ route('projects.index') }}"> Project</a>
                            </li> 
                            <li>
                                <a href="{{ route('task.index') }}"> Task</a>
                            </li>
                           
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
