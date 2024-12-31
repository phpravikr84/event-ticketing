 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">

<div data-simplebar class="h-100">

    <!-- User details -->
    <div class="user-profile text-center mt-3">
        <div class="">
            <img src="{{ asset('assets/images/users/img-people.png') }}" alt="" class="avatar-md rounded-circle">
        </div>
        <div class="mt-3">
            <h4 class="font-size-16 mb-1">{{ auth()->user()->name }}</h4>
            <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
        </div>
    </div>

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>

            <!-- <li>
                <a href="{{ route('administrator.dashboard.organizer') }}" class="waves-effect">
                    <i class="ri-dashboard-line"></i>
                    <span>Dashboard</span>
                </a>
            </li> -->
            @if(auth()->user()->role->name === 'admin')
                <!-- Admin-Specific Links -->
                <li>
                    <a href="{{ route('administrator.dashboard.admin') }}">
                        <i class="ri-dashboard-line"></i> Admin Dashboard
                    </a>
                </li>
            @endif

            @if(auth()->user()->role->name === 'organizer')
                <!-- Organizer-Specific Links -->
                <li>
                    <a href="{{ route('administrator.dashboard.organizer') }}">
                        <i class="ri-dashboard-line"></i> Organizer Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.index') }}">
                        <i class="ri-calendar-event-line"></i>
                        <span>Manage Events</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.create') }}">
                        <i class="ri-add-line"></i> Create Event
                    </a>
                </li>
                <li>
                    <a href="{{ route('tickets.sales') }}">
                        <i class="ri-bar-chart-line"></i> Ticket Sales
                    </a>
                </li>
                <li>
                    <a href="{{ route('attendees.index') }}">
                        <i class="ri-group-line"></i> Attendee Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.index') }}">
                        <i class="ri-file-chart-line"></i> Reports
                    </a>
                </li>
            @endif

            @if(auth()->user()->role->name === 'attendee')
                <!-- Attendee-Specific Links -->
                <li>
                    <a href="{{ route('administrator.dashboard.attendee') }}">
                        <i class="ri-dashboard-line"></i> Attendee Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('my.tickets') }}">
                        <i class="ri-ticket-line"></i> My Tickets
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.discover') }}">
                        <i class="ri-search-line"></i> Discover Events
                    </a>
                </li>
            @endif
            
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->
