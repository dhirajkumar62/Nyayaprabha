
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | User Profile</title>

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
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
            flex-shrink: 0;
            border: 3px solid var(--primary-light);
        }
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
        
        /* Gallery Styles */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        .gallery-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            aspect-ratio: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: var(--surface);
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        .gallery-item .delete-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .gallery-item:hover .delete-btn {
            opacity: 1;
        }
        
        /* Avatar Upload Styles */
        .avatar-upload {
            position: relative;
            cursor: pointer;
            display: flex;
        }
        .avatar-upload input {
            display: none;
        }
        .avatar-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .avatar-upload:hover .avatar-overlay {
            opacity: 1;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select your State"
        });
    });
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
                    
                    <div class="profile-header">
                        <label class="profile-avatar avatar-upload">
                            @if($user->userImage)
                                <img src="{{ asset($user->userImage) }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />
                            @else
                                <i class="fa fa-user"></i>
                            @endif
                            <div class="avatar-overlay"><i class="fa fa-camera"></i></div>
                            <input type="file" name="profile_picture" accept="image/*" onchange="previewAvatar(this)" form="profileForm" />
                        </label>
                        <div>
                            <h2 style="font-size: 1.5rem; margin-bottom: 4px;">{{ $user->fullName }}'s Profile</h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Last Updated: {{ ($user->updationDate && $user->updationDate != '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($user->updationDate)->format('M d, Y h:i A') : 'Never' }}</p>
                        </div>
                    </div>

                    @if(session('successmsg'))
                        <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                            <i class="fa fa-check-circle" style="margin-right: 8px;"></i> {{ session('successmsg') }}
                        </div>
                    @endif

                    @if(session('errormsg'))
                        <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                            <i class="fa fa-exclamation-circle" style="margin-right: 8px;"></i> {{ session('errormsg') }}
                        </div>
                    @endif

                    <form method="post" action="/users/profile" name="profile" id="profileForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" required value="{{ $user->fullName }}" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="useremail" required value="{{ $user->userEmail }}" class="form-control" readonly style="background: var(--background); cursor: not-allowed;">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contactno" required value="{{ $user->contactNo }}" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Registration Date</label>
                                <input type="text" name="regdate" required value="{{ $user->regDate }}" class="form-control" readonly style="background: var(--background); cursor: not-allowed;">
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Address</label>
                                <textarea name="address" required class="form-control" rows="3">{{ $user->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select name="state" required class="form-control select2">
                                    <option value="{{ $user->State }}">{{ $user->State }}</option>
                                    @foreach($states as $rw)
                                        @if($rw->stateName != $user->State)
                                            <option value="{{ $rw->stateName }}">{{ $rw->stateName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" required value="{{ $user->country }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" maxlength="6" required value="{{ $user->pincode }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group full-width" style="margin-top: 30px; border-top: 1px solid var(--border); padding-top: 24px;">
                            <h3 style="font-size: 1.25rem; margin-bottom: 16px; color: var(--text-main);">Image Gallery</h3>
                            <div class="form-group">
                                <label class="form-label">Upload Additional Images</label>
                                <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*" style="padding: 10px;">
                            </div>
                            
                            @if(isset($galleryImages) && $galleryImages->count() > 0)
                            <div class="gallery-grid">
                                @foreach($galleryImages as $img)
                                <div class="gallery-item" id="gallery-item-{{ $img->id }}">
                                    <img src="{{ asset($img->image_path) }}" alt="Gallery Image">
                                    <button type="button" class="delete-btn" onclick="deleteGalleryImage({{ $img->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div style="margin-top: 24px; text-align: right;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save" style="margin-right: 8px;"></i> Save Changes</button>
                        </div>
                    </form>
                </div>

                </div>
            </main>
        </div>
    </div>
    </div>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = $(input).siblings('img');
                    if(img.length > 0) {
                        img.attr('src', e.target.result);
                    } else {
                        $(input).siblings('i').replaceWith('<img src="'+e.target.result+'" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function deleteGalleryImage(id) {
            if(confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: '/users/profile/gallery/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#gallery-item-' + id).fadeOut(300, function() { $(this).remove(); });
                        } else {
                            alert('Failed to delete image.');
                        }
                    },
                    error: function() {
                        alert('Error deleting image.');
                    }
                });
            }
        }
    </script>
</body>
</html>
