Quy trình thiết kế cơ sở dữ liệu (Database Design):

---

### Bước 1: Phân tích yêu cầu nghiệp vụ (Requirement Analysis)
Đây là bước quan trọng nhất để xác định hệ thống cần lưu trữ những gì.
*   **Xác định thực thể:** Liệt kê các đối tượng chính trong ứng dụng (Ví dụ: Người dùng, Sản phẩm, Đơn hàng, Bài viết).
*   **Xác định thuộc tính:** Mỗi đối tượng có những thông tin gì? (Ví dụ: Người dùng có Họ tên, Email, Mật khẩu, Ngày sinh).
*   **Xác định quy tắc nghiệp vụ:** Ví dụ: Một đơn hàng phải thuộc về một người dùng; một sản phẩm có thể thuộc về nhiều danh mục.

### Bước 2: Xây dựng sơ đồ Thực thể - Quan hệ (ER Diagram)
Sử dụng các công cụ (như Draw.io, Lucidchart, hoặc MySQL Workbench) để vẽ sơ đồ kết nối các thực thể.
*   **Xác định loại quan hệ:**
    *   **1 - 1 (Một - Một):** Một người dùng chỉ có một hồ sơ cá nhân.
    *   **1 - n (Một - Nhiều):** Một danh mục có nhiều sản phẩm.
    *   **n - n (Nhiều - Nhiều):** Một bài viết có nhiều thẻ (tags), và một thẻ có thể gắn cho nhiều bài viết.
*   **Giải quyết quan hệ Nhiều - Nhiều:** Tạo thêm một bảng trung gian để tách quan hệ n-n thành hai quan hệ 1-n.

### Bước 3: Chuẩn hóa cơ sở dữ liệu (Normalization)
Mục tiêu là loại bỏ sự dư thừa dữ liệu và đảm bảo tính nhất quán.
*   **Chuẩn 1 (1NF):** Mỗi ô dữ liệu chỉ chứa một giá trị duy nhất (không lưu danh sách giá trị trong một cột).
*   **Chuẩn 2 (2NF):** Đảm bảo mọi cột không phải khóa đều phụ thuộc hoàn toàn vào khóa chính.
*   **Chuẩn 3 (3NF):** Loại bỏ các phụ thuộc bắc cầu (Ví dụ: Không lưu "Tên thành phố" trong bảng "Nhân viên" nếu đã có "Mã thành phố").

### Bước 4: Thiết kế Logic và Vật lý (Logical & Physical Design)
Chuyển sơ đồ ERD thành các bảng cụ thể với định nghĩa kỹ thuật:
*   **Đặt tên bảng và cột:** Sử dụng tiếng Anh, viết thường, ngăn cách bằng dấu gạch dưới (ví dụ: `user_accounts`, `order_details`).
*   **Chọn kiểu dữ liệu (Data Types):**
    *   Số nguyên: `INT`, `BIGINT`.
    *   Chuỗi: `VARCHAR` (cho độ dài linh hoạt), `TEXT` (cho nội dung dài).
    *   Ngày tháng: `DATE`, `DATETIME`, `TIMESTAMP`.
    *   Tiền tệ: `DECIMAL` (không dùng Float để tránh sai số).
*   **Xác định Khóa (Keys):** Khóa chính (Primary Key) cho mỗi bảng và Khóa ngoại (Foreign Key) để liên kết.

### Bước 5: Định nghĩa các Ràng buộc và Chỉ mục (Constraints & Indexes)
Tăng cường tính an toàn và tốc độ cho Database.
*   **Constraints:** Áp dụng `NOT NULL`, `UNIQUE`, `CHECK` và `DEFAULT` để kiểm soát dữ liệu đầu vào ngay tại tầng DB.
*   **Indexes:** Tạo chỉ mục (Index) cho các cột thường xuyên xuất hiện trong mệnh đề `WHERE` hoặc các cột dùng để `JOIN` để tăng tốc độ truy vấn.

### Bước 6: Triển khai SQL và Kiểm thử (Implementation & Testing)
*   **Viết Script DDL:** Viết lệnh `CREATE TABLE` để khởi tạo cấu trúc.
*   **Thêm dữ liệu mẫu (Dummy Data):** Nhập dữ liệu giả định để kiểm tra các mối liên kết bảng có hoạt động đúng như thiết kế hay không.
*   **Kiểm tra truy vấn:** Viết thử các câu lệnh `SELECT` phức tạp (nhiều JOIN) để đảm bảo cấu trúc bảng hỗ trợ tốt cho việc lấy dữ liệu của ứng dụng Web.

---

### Các công cụ hỗ trợ thiết kế phổ biến:
1.  **Vẽ sơ đồ:** Lucidchart, dbdiagram.io (rất nhanh và trực quan).
2.  **Quản trị và thiết kế trực tiếp:** MySQL Workbench, SQL Server Management Studio (SSMS), pgAdmin.
3.  **Công cụ đa năng:** DBeaver (hỗ trợ hầu hết các loại RDBMS).
