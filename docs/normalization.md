Chuẩn hóa cơ sở dữ liệu (Normalization) là quá trình tổ chức lại dữ liệu trong các bảng nhằm giảm thiểu dư thừa và ngăn chặn các lỗi logic khi thêm, sửa hoặc xóa dữ liệu (Anomalies).

Dưới đây là chi tiết về các dạng chuẩn 1NF, 2NF, 3NF và kỹ thuật khử chuẩn.

---

### 1. Dạng chuẩn 1 (1NF - First Normal Form)

**Quy tắc:**
*   Mỗi ô (giao giữa hàng và cột) phải chứa một giá trị nguyên tố (Atomic Value) – không chứa danh sách hoặc mảng.
*   Không có các nhóm cột lặp lại.
*   Mỗi hàng phải là duy nhất (có khóa chính).

#### Ví dụ 1: Cột chứa nhiều giá trị
*   **Chưa chuẩn hóa:** Bảng `SinhVien` có cột `SoDienThoai` chứa: "090..., 091...".
*   **Vấn đề:** Khó tìm kiếm số điện thoại cụ thể, không thể đặt ràng buộc định dạng.
*   **Sửa đổi:** Tách thành 2 dòng cho cùng một sinh viên hoặc tạo bảng số điện thoại riêng.
*   **Lý do:** Giúp việc truy vấn `WHERE SoDienThoai = '...'` chính xác và hiệu quả.

#### Ví dụ 2: Nhóm cột lặp lại
*   **Chưa chuẩn hóa:** Bảng `DuAn` có các cột: `NhanVien1`, `NhanVien2`, `NhanVien3`.
*   **Vấn đề:** Nếu một dự án có 4 nhân viên thì phải sửa cấu trúc bảng (thêm cột). Nếu chỉ có 1 nhân viên thì lãng phí 2 cột NULL.
*   **Sửa đổi:** Tạo bảng trung gian `DuAn_NhanVien` với mỗi hàng là một cặp (MaDuAn, MaNhanVien).
*   **Lý do:** Đảm bảo tính linh hoạt, không giới hạn số lượng nhân viên và tối ưu không gian lưu trữ.

---

### 2. Dạng chuẩn 2 (2NF - Second Normal Form)

**Quy tắc:**
*   Phải đạt chuẩn 1NF.
*   Mọi thuộc tính không phải khóa phải phụ thuộc hoàn toàn vào **toàn bộ** khóa chính (áp dụng cho bảng có khóa chính hỗn hợp/composite key).

#### Ví dụ 1: Phụ thuộc vào một phần khóa
*   **Chưa chuẩn hóa:** Bảng `KetQuaHocTap` (MaSV, MaMonHoc, TenMonHoc, Diem). Khóa chính là (MaSV, MaMonHoc).
*   **Vấn đề:** `TenMonHoc` chỉ phụ thuộc vào `MaMonHoc`, không phụ thuộc vào `MaSV`. Nếu môn học chưa có ai thi, thông tin tên môn học sẽ không tồn tại trong DB.
*   **Sửa đổi:** Tách thành 2 bảng: `MonHoc` (MaMonHoc, TenMonHoc) và `KetQua` (MaSV, MaMonHoc, Diem).
*   **Lý do:** Loại bỏ dư thừa tên môn học (lặp lại nhiều lần cho mỗi SV) và cho phép quản lý danh mục môn học độc lập với kết quả thi.

#### Ví dụ 2: Thông tin sản phẩm trong đơn hàng
*   **Chưa chuẩn hóa:** Bảng `ChiTietDonHang` (MaDonHang, MaSanPham, TenSanPham, SoLuong). Khóa chính là (MaDonHang, MaSanPham).
*   **Vấn đề:** `TenSanPham` lặp lại mỗi khi sản phẩm đó được bán. Nếu muốn đổi tên sản phẩm, phải update hàng ngàn dòng.
*   **Sửa đổi:** Tách bảng `SanPham` (MaSanPham, TenSanPham) và bảng `ChiTietDonHang` chỉ giữ lại `MaSanPham`.
*   **Lý do:** Đảm bảo tính nhất quán (Data Consistency), chỉ cần đổi tên sản phẩm tại một nơi duy nhất.

---

### 3. Dạng chuẩn 3 (3NF - Third Normal Form)

**Quy tắc:**
*   Phải đạt chuẩn 2NF.
*   Không có phụ thuộc bắc cầu (Transitive Dependency): Thuộc tính không phải khóa không được phụ thuộc vào một thuộc tính không phải khóa khác.

#### Ví dụ 1: Phụ thuộc qua cột trung gian
*   **Chưa chuẩn hóa:** Bảng `NhanVien` (MaNV, HoTen, MaPhongBan, TenPhongBan).
*   **Vấn đề:** `TenPhongBan` phụ thuộc vào `MaPhongBan`, trong khi `MaPhongBan` phụ thuộc vào `MaNV`. Nếu phòng ban chưa có nhân viên, thông tin phòng đó sẽ bị mất.
*   **Sửa đổi:** Tách thành bảng `NhanVien` (MaNV, HoTen, MaPhongBan) và bảng `PhongBan` (MaPhongBan, TenPhongBan).
*   **Lý do:** Tránh lỗi khi xóa nhân viên cuối cùng của phòng ban dẫn đến mất luôn thông tin phòng ban (Delete Anomaly).

#### Ví dụ 2: Địa chỉ hành chính
*   **Chưa chuẩn hóa:** Bảng `KhachHang` (MaKH, HoTen, MaPhuong, TenQuan).
*   **Vấn đề:** `TenQuan` phụ thuộc vào `MaPhuong`. Đây là phụ thuộc bắc cầu.
*   **Sửa đổi:** Tách bảng `PhuongXa` (MaPhuong, TenPhuong, MaQuan) và bảng `QuanHuyen` (MaQuan, TenQuan).
*   **Lý do:** Chuẩn hóa dữ liệu địa chỉ giúp đồng bộ thông tin, tránh việc một Quận có nhiều tên gọi khác nhau do nhập liệu sai ở bảng Khách hàng.

---

### 4. Khử chuẩn (Denormalization)

**Định nghĩa:** Là quá trình cố ý thêm dữ liệu dư thừa vào một cơ sở dữ liệu đã chuẩn hóa để cải thiện tốc độ truy vấn (Read Performance).

#### Ví dụ 1: Lưu trữ tổng tiền đơn hàng
*   **Tình huống:** Bảng `DonHang` có thêm cột `TongTien`. Thay vì mỗi lần xem danh sách đơn hàng phải JOIN với bảng `ChiTietDonHang` và dùng hàm `SUM()`.
*   **Tại sao làm vậy:** Phép tính SUM và JOIN trên hàng triệu dòng rất chậm. Lưu trực tiếp kết quả giúp báo cáo hiển thị tức thì.
*   **Đánh giá:** Chấp nhận rủi ro dữ liệu lệch (nếu quên cập nhật TongTien khi sửa chi tiết đơn hàng) để đổi lấy tốc độ.

#### Ví dụ 2: Lưu tên sản phẩm vào bảng chi tiết
*   **Tình huống:** Trong bảng `ChiTietDonHang`, ngoài `MaSP` ta lưu thêm cả `TenSP` tại thời điểm bán.
*   **Tại sao làm vậy:** Để in hóa đơn nhanh mà không cần JOIN sang bảng sản phẩm. Ngoài ra, nó giữ lại lịch sử tên sản phẩm tại thời điểm bán (nếu sau này bảng `SanPham` đổi tên, hóa đơn cũ vẫn giữ đúng tên lúc khách mua).
*   **Đánh giá:** Phù hợp cho các hệ thống cần truy xuất dữ liệu lịch sử ổn định và giảm tải cho CPU khi thực hiện các câu lệnh JOIN phức tạp.

---

### Tóm tắt so sánh
*   **Chuẩn hóa (1NF, 2NF, 3NF):** Ưu tiên **Tính nhất quán** và **Tiết kiệm dung lượng**. Thích hợp cho các hệ thống giao dịch (OLTP).
*   **Khử chuẩn:** Ưu tiên **Tốc độ truy vấn**. Thích hợp cho các hệ thống báo cáo, kho dữ liệu (Data Warehouse).
