@extends('layouts.user')

@section('content')
<div class="container pt-4 pb-4">
    <div class="user_titles mb-4">
        <span>
            <a href="{{ route('user.index') }}">Trang chủ</a>
        </span>
        <span>/ Đăng ký KTX</span>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="border rounded p-3 shadow-sm" style="background-color: #fff;">
                <h5 class="mb-3">Thông tin tài khoản</h5>
                <ul class="list-unstyled">
                    <li class="mt-2"><strong>Họ tên:</strong> {{ $user->name }}</li>
                    <li class="mt-2"><strong>Mã sinh viên:</strong> {{ $user->msv }}</li>
                    <li class="mt-2"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="mt-2"><strong>Số điện thoại:</strong> {{ $user->tel }}</li>
                    <li class="mt-2"><strong>Trạng thái đăng ký KTX:</strong>
                        <div class="mt-1">
                            @if ($member)
                                @if ($member->status == 0)
                                    <span class="badge bg-success">Đã đăng ký</span>
                                @elseif ($member->status == 2)
                                    <span class="badge bg-warning text-dark">Chờ duyệt ĐK KTX</span>
                                @elseif ($member->status == 3)
                                    <span class="badge bg-warning text-dark">Chờ duyệt hủy KTX</span>
                                @else
                                    <span class="badge bg-danger">Chưa đăng ký</span>
                                @endif
                            @else
                                <span class="badge bg-danger">Chưa đăng ký</span>
                            @endif
                        </div>
                    </li>
                </ul>

                @if ($member && ($member->status == 0 || $member->status == 2))
                    <form method="POST" action="{{ route('user.requestCancelKTX') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            @if ($member->status == 0)
                                Yêu cầu hủy ĐK KTX
                            @elseif ($member->status == 2)
                                Hủy Yêu cầu ĐK KTX
                            @endif
                        </button>
                    </form>
                @endif

                {{-- Hiển thị thông tin phòng đã đăng ký --}}
                @if ($member && $member->status == 0)
                    <div class="mt-4 border-top pt-3">
                        <h6 class="mb-2">Thông tin phòng đã đăng ký:</h6>
                        <ul class="list-unstyled" id="registered-room-info">
                            <li class="mt-1"><strong>Danh mục:</strong> <span id="registered-category-name"></span></li>
                            <li class="mt-1"><strong>Phòng:</strong> <span id="registered-room-name"></span></li>
                            <li class="mt-1"><strong>Số lượng người ở tối đa:</strong> <span id="registered-room-quantity"></span></li>
                            <li class="mt-1"><strong>Loại phòng:</strong> <span id="registered-room-type"></span></li>
                            <li class="mt-1"><strong>Giá phòng:</strong> <span id="registered-room-price"></span></li>
                            <li class="mt-1"><strong>Trạng thái phòng:</strong> <span id="registered-room-status"></span></li>
                        </ul>
                    </div>
                @else
                    {{-- Hiển thị thông tin chọn phòng nếu chưa đăng ký hoặc đang chờ duyệt --}}
                    <div class="mt-4 border-top pt-3">
                        <h6 class="mb-2">Thông tin đã chọn:</h6>
                        <ul class="list-unstyled">
                            <li class="mt-1"><strong>Danh mục:</strong> <span id="selected-category"></span></li>
                            <li class="mt-1"><strong>Phòng KTX:</strong> <span id="selected-room"></span></li>
                            <li class="mt-1"><strong>Số lượng người ở tối đa:</strong> <span id="room-quantity"></span></li>
                            <li class="mt-1"><strong>Số lượng người ở hiện tại:</strong> <span id="room-current-quantity"></span></li>
                            <li class="mt-1"><strong>Loại phòng:</strong> <span id="room-type"></span></li>
                            <li class="mt-1"><strong>Giá phòng:</strong> <span id="room-price"></span></li>
                            <li class="mt-1"><strong>Trạng thái phòng:</strong> <span id="room-status"></span></li>
                        </ul>
                    </div>

                    {{-- Hiển thị danh sách thành viên trong phòng đã chọn --}}
                    <div class="mt-4 border-top pt-3">
                        <h6 class="mb-2">Thành viên trong phòng: <span id="selected-room-name-members"></span></h6>
                        <ul class="list-unstyled" id="room-members-list">
                            {{-- Danh sách thành viên sẽ được hiển thị ở đây --}}
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="Ktx_body">
                <div class="cart border rounded p-4 shadow-sm">
                    <form method="POST" action="{{ route('user.registerKTX') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="idCategory">Chọn danh mục: </label>
                            <select class="form-select mt-2" name="idCategory" id="idCategory" @if($member && $member->status == 0) disabled @endif required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="idRoom">Phòng KTX: <span>*</span></label>
                            <select class="form-select mt-2" name="idRoom" id="idRoom" @if($member && $member->status == 0) disabled @endif required>
                                <option value="">Chọn phòng KTX</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Họ tên: <span>*</span></label>
                            <input type="text" id="name" class="form-control mt-2" name="name" value="{{ Auth::user()->name }}" required disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="msv">Mã sinh viên: <span>*</span></label>
                            <input type="text" id="msv" class="form-control mt-2" name="msv" value="{{ Auth::user()->msv }}" required disabled>
                        </div>

                        <div class="form_footer mt-4">
                            <button type="submit" class="btn btn-success" @if($member && $member->status == 0) disabled @endif>
                                @if($member && $member->status == 0) Đã đăng ký @else Đăng ký @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('idCategory');
        const roomSelect = document.getElementById('idRoom');
        const selectedCategorySpan = document.getElementById('selected-category');
        const selectedRoomSpan = document.getElementById('selected-room');
        const roomQuantitySpan = document.getElementById('room-quantity');
        const roomCurrentQuantitySpan = document.getElementById('room-current-quantity');
        const roomTypeSpan = document.getElementById('room-type');
        const roomPriceSpan = document.getElementById('room-price');
        const roomStatusSpan = document.getElementById('room-status');

        // Elements for registered room info
        const registeredCategoryNameSpan = document.getElementById('registered-category-name');
        const registeredRoomNameSpan = document.getElementById('registered-room-name');
        const registeredRoomQuantitySpan = document.getElementById('registered-room-quantity');
        const registeredRoomTypeSpan = document.getElementById('registered-room-type');
        const registeredRoomPriceSpan = document.getElementById('registered-room-price');
        const registeredRoomStatusSpan = document.getElementById('registered-room-status');

        // Elements for room members list
        const roomMembersList = document.getElementById('room-members-list');
        const selectedRoomNameMembers = document.getElementById('selected-room-name-members');

        @if ($member && $member->status == 0)
            // Nếu đã đăng ký, lấy thông tin phòng đã đăng ký
            fetch(`/get-room-details/{{ $member->idRoom }}`)
                .then(response => response.json())
                .then(room => {
                    fetch(`/get-category-details/${room.idCategory}`)
                        .then(response => response.json())
                        .then(category => {
                            registeredCategoryNameSpan.textContent = category.name;
                        })
                        .catch(error => console.error('Error fetching category:', error));

                    registeredRoomNameSpan.textContent = room.name;
                    registeredRoomQuantitySpan.textContent = room.quantity;
                    registeredRoomTypeSpan.textContent = room.type === 'nam' ? 'Nam' : (room.type === 'nữ' ? 'Nữ' : 'Không xác định');
                    registeredRoomPriceSpan.textContent = formatCurrency(room.price);
                    registeredRoomStatusSpan.textContent = getStatusText(room.status);

                    // Disable the select elements
                    categorySelect.disabled = true;
                    roomSelect.disabled = true;
                })
                .catch(error => console.error('Error fetching registered room:', error));
        @else
            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                selectedCategorySpan.textContent = this.options[this.selectedIndex].textContent;
                roomSelect.innerHTML = '<option value="">Chọn phòng KTX</option>';
                clearRoomDetails();
                clearRoomMembers();

                if (categoryId) {
                    fetch(`/get-rooms/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(room => {
                                const option = document.createElement('option');
                                option.value = room.id;
                                option.textContent = room.name;
                                roomSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    selectedCategorySpan.textContent = '';
                }
            });

            roomSelect.addEventListener('change', function() {
                const roomId = this.value;
                clearRoomDetails();
                clearRoomMembers();

                if (roomId) {
                    fetch(`/get-room-details/${roomId}`)
                        .then(response => response.json())
                        .then(room => {
                            selectedRoomSpan.textContent = room.name;
                            selectedRoomNameMembers.textContent = room.name;
                            roomQuantitySpan.textContent = room.quantity;
                            roomCurrentQuantitySpan.textContent = room.members.length;
                            roomTypeSpan.textContent = room.type === 'nam' ? 'Nam' : (room.type === 'nữ' ? 'Nữ' : 'Không xác định');
                            roomPriceSpan.textContent = formatCurrency(room.price);
                            roomStatusSpan.textContent = getStatusText(room.status);

                            // Hiển thị danh sách thành viên
                            if (room.members && room.members.length > 0) {
                                room.members.forEach(member => {
                                    const listItem = document.createElement('li');
                                    listItem.classList.add('mt-1');
                                    listItem.innerHTML = `<strong>- ${member.name}</strong> (MSV: ${member.msv})`;
                                    roomMembersList.appendChild(listItem);
                                });
                            } else {
                                const listItem = document.createElement('li');
                                listItem.textContent = 'Phòng hiện chưa có thành viên.';
                                roomMembersList.appendChild(listItem);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    selectedRoomSpan.textContent = '';
                    selectedRoomNameMembers.textContent = '';
                }
            });
        @endif

        function clearRoomDetails() {
            selectedRoomSpan.textContent = '';
            roomQuantitySpan.textContent = '';
            roomCurrentQuantitySpan.textContent = '';
            roomTypeSpan.textContent = '';
            roomPriceSpan.textContent = '';
            roomStatusSpan.textContent = '';
        }

        function clearRoomMembers() {
            roomMembersList.innerHTML = '';
        }

        function formatCurrency(number) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }

        function getStatusText(status) {
            switch (status) {
                case 0:
                    return 'Hoạt động';
                case 1:
                    return 'Ngừng hoạt động';
                case 2:
                    return 'Bảo trì';
                default:
                    return 'Không xác định';
            }
        }
    });
</script>

@endsection