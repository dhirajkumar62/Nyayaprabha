<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpline & Support Management</title>
    
    <link href="/css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 280px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; z-index: 10; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: var(--background); }
        
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title { font-size: 1.5rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 12px; }
        
        .tabs-container { display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 10px; }
        .tab-btn { padding: 10px 20px; font-size: 0.95rem; font-weight: 600; color: var(--text-muted); background: transparent; border: none; cursor: pointer; border-radius: var(--radius-sm); transition: var(--transition); }
        .tab-btn:hover { color: var(--primary); background: var(--primary-light); }
        .tab-btn.active { color: var(--primary); background: var(--primary-light); border-bottom: 3px solid var(--primary); border-bottom-left-radius: 0; border-bottom-right-radius: 0; }

        .data-panel { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
        
        .panel-toolbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid var(--border); background: #fdfdfd; }
        .search-box { position: relative; width: 300px; }
        .search-box i { position: absolute; left: 12px; top: 12px; color: var(--text-muted); }
        .search-box input { width: 100%; padding: 10px 10px 10px 36px; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: var(--background); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; padding: 16px 24px; text-align: left; border-bottom: 1px solid var(--border); }
        td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 0.95rem; color: var(--text-main); }
        
        .action-icon { display: inline-flex; width: 32px; height: 32px; border-radius: 8px; align-items: center; justify-content: center; margin-right: 8px; transition: var(--transition); cursor: pointer; }
        .icon-edit { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .icon-delete { background: rgba(239, 68, 68, 0.1); color: #EF4444; }

        .modal-bg { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal-content { background: var(--surface); padding: 30px; border-radius: var(--radius-lg); width: 100%; max-width: 500px; box-shadow: var(--shadow-lg); }
    </style>
    <script>
        function openModal() { document.getElementById('addModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('addModal').style.display = 'none'; }
    </script>
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('admin.include.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            @include('admin.include.header')
            
            <main class="main-content">
                <div class="page-header">
                    <h2 class="page-title"><i class="fa fa-hands-helping" style="color: var(--accent);"></i> Helpline & Support Management</h2>
                </div>

                @if(session('msg'))
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500;">
                        <i class="fa fa-check-circle"></i> {{ session('msg') }}
                    </div>
                @endif

                <div class="tabs-container">
                    <a href="?tab=helplines"><button class="tab-btn {{ $active_tab == 'helplines' ? 'active' : '' }}"><i class="fa fa-phone-alt"></i> Emergency Helplines</button></a>
                    <a href="?tab=ngos"><button class="tab-btn {{ $active_tab == 'ngos' ? 'active' : '' }}"><i class="fa fa-hand-holding-heart"></i> NGOs</button></a>
                    <a href="?tab=police"><button class="tab-btn {{ $active_tab == 'police' ? 'active' : '' }}"><i class="fa fa-shield-alt"></i> Police Stations</button></a>
                    <a href="?tab=support"><button class="tab-btn {{ $active_tab == 'support' ? 'active' : '' }}"><i class="fa fa-building"></i> Support Centers</button></a>
                </div>

                <div class="data-panel">
                    <div class="panel-toolbar">
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search records...">
                        </div>
                        @if($active_tab == 'helplines')
                            <button class="btn btn-primary" onclick="openModal()"><i class="fa fa-plus"></i> Add New Helpline</button>
                        @else
                            <button class="btn btn-primary" onclick="alert('Feature coming soon in advanced phase.')"><i class="fa fa-plus"></i> Add New Record</button>
                        @endif
                    </div>

                    <div style="overflow-x: auto;">
                        <table>
                            @if($active_tab == 'helplines')
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service Name</th>
                                        <th>Number</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($helplines as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="font-weight: 600; color: var(--primary);">{{ $row->name }}</td>
                                        <td style="font-size: 1.1rem; font-weight: 700; color: var(--accent);"><i class="fa fa-phone-square-alt"></i> {{ $row->number }}</td>
                                        <td><span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $row->category }}</span></td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <a href="/admin/helplines/delete/{{ $row->id }}" onClick="return confirm('Are you sure you want to delete?')" class="action-icon icon-delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                            <i class="fa fa-wrench" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                            This section is under construction.
                                        </td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Helpline Modal -->
    <div class="modal-bg" id="addModal">
        <div class="modal-content">
            <h3 style="margin-bottom: 20px; font-size: 1.3rem; border-bottom: 1px solid var(--border); padding-bottom: 16px;">Add Emergency Helpline</h3>
            <form method="post" action="/admin/helplines">
                @csrf
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Service Name</label>
                    <input type="text" name="h_name" class="form-control" placeholder="e.g. Cyber Crime Helpline" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                </div>
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Contact Number</label>
                    <input type="text" name="h_number" class="form-control" placeholder="e.g. 1930" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                </div>
                <div class="form-group" style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Category</label>
                    <select name="h_category" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                        <option value="Emergency">Emergency</option>
                        <option value="Police">Police</option>
                        <option value="Women Safety">Women Safety</option>
                        <option value="Domestic Violence">Domestic Violence</option>
                        <option value="Medical">Medical</option>
                        <option value="Cyber Crime">Cyber Crime</option>
                        <option value="Child Safety">Child Safety</option>
                        <option value="NGO">NGO Support</option>
                    </select>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: var(--primary);">Save Helpline</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
