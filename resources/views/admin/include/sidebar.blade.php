<div class="sidebar-menu-wrapper" style="padding: 30px 0;">
    <div class="user-profile" style="text-align: center; margin-bottom: 40px; padding: 0 24px;">
        <img src="https://img.icons8.com/glyph-neue/64/administrator-male.png" width="70" style="border-radius: 50%; border: 3px solid var(--primary-light); margin-bottom: 12px; padding: 4px; background: white; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 1.05rem; color: var(--text-main); font-weight: 700; margin-bottom: 2px;">Administrator</h4>
        <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Women Safety Portal</p>
    </div>

    <ul class="sidebar-menu" style="list-style: none; padding: 0;">
        <li style="margin-bottom: 4px;">
            <a href="/admin/dashboard" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-th-large" style="margin-right: 16px; font-size: 1.1rem; color: var(--primary); opacity: 0.8; width: 20px; text-align: center;"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li style="padding: 28px 24px 10px; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Emergency & Complaints</li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/notprocess-complaint" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-file-signature" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>New Complaints</span>
            </a>
        </li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/inprocess-complaint" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-spinner" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>Pending Cases</span>
            </a>
        </li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/closed-complaint" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-check-circle" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>Resolved</span>
            </a>
        </li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/helplines" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-phone-alt" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>Helplines</span>
            </a>
        </li>

        <li style="padding: 28px 24px 10px; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Management</li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/manage-users" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-users" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>Users</span>
            </a>
        </li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/category" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-tags" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>Categories</span>
            </a>
        </li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/state" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-map-marker-alt" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>States</span>
            </a>
        </li>
        <li style="margin-bottom: 4px;">
            <a href="/admin/user-logs" style="display: flex; align-items: center; padding: 12px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; border-radius: 0 24px 24px 0; margin-right: 16px; transition: var(--transition);">
                <i class="fa fa-history" style="margin-right: 16px; font-size: 1.1rem; color: var(--text-muted); width: 20px; text-align: center;"></i>
                <span>User Logs</span>
            </a>
        </li>
    </ul>
    
    <style>
        .sidebar-menu li a:hover { background: var(--primary-light); color: var(--primary) !important; }
        .sidebar-menu li a:hover i { color: var(--primary) !important; opacity: 1 !important; }
    </style>
</div>
