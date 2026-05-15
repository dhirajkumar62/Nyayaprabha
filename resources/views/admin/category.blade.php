<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin Categories</title>

    <link href="/css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 260px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        
        .table-container { background: var(--surface); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: var(--primary-light); }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('admin.include.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            @include('admin.include.header')
            
            <main class="main-content">
                <div style="margin-bottom: 24px;">
                    <h2><i class="fa fa-folder" style="margin-right: 10px; color: var(--primary);"></i> Category Management</h2>
                </div>
                
                @if(session('msg'))
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                        {{ session('msg') }}
                    </div>
                @endif

                @if(session('delmsg'))
                    <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                        {{ session('delmsg') }}
                    </div>
                @endif

                <div class="card" style="margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; font-size: 1.25rem;">Create Category</h3>
                    <form name="Category" method="post" action="/admin/category" style="max-width: 600px;">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Category Name</label>
                            <input type="text" placeholder="Enter category Name" name="category" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter category description"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </form>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Creation date</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $index => $row)                                  
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="font-weight: 600; color: var(--text-main);">{{ $row->categoryName }}</td>
                                <td>{{ $row->categoryDescription }}</td>
                                <td style="color: var(--text-muted);">{{ $row->creationDate }}</td>
                                <td style="color: var(--text-muted);">{{ $row->updationDate }}</td>
                                <td>
                                    <a href="/admin/category/delete/{{ $row->id }}" onClick="return confirm('Are you sure you want to delete?')" style="color: var(--error);"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
