<div class="sidebar-menu-wrapper" style="padding: 24px 0;">
<?php $userRecord = \Illuminate\Support\Facades\DB::table('users')->where('id', \Illuminate\Support\Facades\Session::get('id'))->first(); ?>
    <div class="user-profile" style="text-align: center; margin-bottom: 30px; padding: 0 24px;">
        @if($userRecord && $userRecord->userImage)
            <img src="{{ asset($userRecord->userImage) }}" width="80" height="80" style="border-radius: 50%; border: 3px solid var(--primary-light); margin-bottom: 16px; object-fit: cover;">
        @else
            <img src="https://w7.pngwing.com/pngs/4/736/png-transparent-female-avatar-girl-face-woman-user-flat-classy-users-icon.png" width="80" height="80" style="border-radius: 50%; border: 3px solid var(--primary-light); margin-bottom: 16px; object-fit: cover;">
        @endif
        <h4 style="font-size: 1.1rem; color: var(--text-main); font-weight: 700;">{{ $userRecord ? $userRecord->fullName : 'User' }}</h4>
        <p style="font-size: 0.875rem; color: var(--text-muted);">User Account</p>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="/users/dashboard">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="alert('Emergency SOS Activated!')" style="color: var(--accent); font-weight: 700;">
                <i class="fa fa-exclamation-triangle"></i>
                <span>Emergency SOS</span>
            </a>
        </li>
        <li>
            <a href="/users/register-complaint">
                <i class="fa fa-shield-alt"></i>
                <span>Lodge Complaint</span>
            </a>
        </li>
        <li>
            <a href="/users/complaint-history">
                <i class="fa fa-clipboard-list"></i>
                <span>Track Complaint</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-map-marker-alt"></i>
                <span>Live Location</span>
            </a>
        </li>
        <li>
            <a href="/users/helplines">
                <i class="fa fa-phone-alt"></i>
                <span>Helplines</span>
            </a>
        </li>
        <li>
            <a href="/users/emergency-contacts">
                <i class="fa fa-heartbeat"></i>
                <span>Emergency Contacts</span>
            </a>
        </li>
        <li>
            <a href="/users/profile">
                <i class="fa fa-user-cog"></i>
                <span>Profile Settings</span>
            </a>
        </li>
        <li>
            <a href="/users/change-password">
                <i class="fa fa-key"></i>
                <span>Change Password</span>
            </a>
        </li>
    </ul>
</div>