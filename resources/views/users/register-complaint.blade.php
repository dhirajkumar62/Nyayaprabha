

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Lodge Complaint</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 260px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li a { display: block; padding: 16px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; }
        .sidebar-menu li a:hover { background: var(--primary-light); color: var(--primary); }
        .sidebar-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .topbar { background: var(--surface); padding: 16px 30px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .full-width { grid-column: span 2; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 48px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background-color: var(--background);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main);
            line-height: 46px;
            padding-left: 16px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select your State",
            allowClear: true
        });
    });
    
    function getCat(val) {
        $.ajax({
            type: "POST",
            url: "/users/getsubcat",
            data: {
                catid: val,
                _token: '{{ csrf_token() }}'
            },
            success: function(data){
                $("#subcategory").html(data);
            }
        });
    }
    </script>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('users.includes.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            @include('users.includes.header')
            
            <main class="main-content">
                <div class="card" style="max-width: 800px; margin: 0 auto;">
                    <div style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 24px;">
                        <h2 style="font-size: 1.5rem;"><i class="fa fa-pencil-alt" style="margin-right: 10px; color: var(--primary);"></i> Lodge New Complaint</h2>
                    </div>

                    @if(session('successmsg'))
                        <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                            {{ session('successmsg') }}
                        </div>
                        <script>alert("{{ session('successmsg') }}");</script>
                    @endif

                    @if(session('errormsg'))
                        <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                            {{ session('errormsg') }}
                        </div>
                    @endif

                    <form method="post" action="/users/register-complaint" name="complaint" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select name="category" id="category" class="form-control" onChange="getCat(this.value);" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $rw)
                                        <option value="{{ $rw->id }}">{{ $rw->categoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Sub Category</label>
                                <select name="subcategory" id="subcategory" class="form-control">
                                    <option value="">Select Subcategory</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Complaint Type</label>
                                <select name="complaintype" class="form-control" required>
                                    <option value="Complaint">Complaint</option>
                                    <option value="General Query">General Query</option>
                                </select> 
                            </div>

                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select name="state" class="form-control select2" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $rw)
                                        <option value="{{ $rw->stateName }}">{{ $rw->stateName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Nature of Complaint</label>
                                <input type="text" name="noc" required class="form-control" placeholder="Brief description of the issue">
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Complaint Details (max 2000 words)</label>
                                <textarea name="complaindetails" required class="form-control" rows="6" maxlength="2000" placeholder="Provide complete details here..."></textarea>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Complaint Related Document (if any)</label>
                                <input type="file" name="compfile" class="form-control" style="padding: 9px 16px;">
                            </div>
                        </div>

                        <div style="margin-top: 24px; text-align: right;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-paper-plane" style="margin-right: 8px;"></i> Submit Complaint</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
