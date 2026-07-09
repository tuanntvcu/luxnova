# LuxNova Admin User Guide

Tài liệu này hướng dẫn cách chỉnh nội dung, ảnh và các cấu hình trong admin WordPress của theme LuxNova. Mục tiêu là giúp editor biết chính xác phải vào đâu để sửa từng page, từng khối nội dung, và các cấu hình toàn site.

## 1. Tổng quan nhanh

Theme LuxNova chia nội dung thành 4 nhóm chính:

1. Nội dung theo trang riêng, chỉnh trong từng Page có template ACF.
2. Nội dung theo bài viết custom post type, như Dự án, Dịch vụ, Đánh giá.
3. Nội dung global trong LuxNova Settings, dùng chung cho header, footer, contact, share image và các popup hoặc archive.
4. Menu WordPress chuẩn, chỉnh trong Appearance > Menus.

Nếu một field để trống, theme thường sẽ dùng nội dung mặc định sẵn trong code. Vì vậy khi chỉnh sửa, bạn nên ưu tiên thay đúng field của trang hoặc settings tương ứng, thay vì sửa trực tiếp nội dung của phần khác.

## 2. Các vị trí admin cần nhớ

### Pages

Các page có template riêng sẽ có thêm các nhóm field ACF ngay bên dưới khung soạn thảo. Đây là nơi chỉnh hầu hết nội dung của website.

### Projects

Đây là custom post type Dự án. Mỗi project có title, nội dung, featured image và các field chi tiết như diện tích, phong cách, ngân sách, gallery, ảnh trước sau.

### Services

Đây là custom post type Dịch vụ. Mỗi service có title, nội dung, featured image và icon hiển thị trên archive.

### Đánh giá khách hàng

Đây là custom post type dành cho testimonial. Mỗi mục có sao, quote, context và avatar.

### LuxNova Settings

Đây là trang cấu hình chung của theme, chứa logo, tagline, CTA header, footer description, phone, email, address, map, social links, ảnh chia sẻ mặc định và các nội dung dùng chung cho archive hoặc popup.

### Appearance > Menus

Theme dùng 4 menu location chính: Primary, Footer Links, Footer Services, Footer Support.

## 3. Chỉnh theo từng page

### 3.1. Trang chủ

Chỉnh tại page đang được đặt làm homepage trong Settings > Reading.

Vào Pages > chọn trang chủ > nhóm ACF Các khối trang chủ.

Trang này dùng Flexible Content, nghĩa là bạn có thể thêm, xóa, kéo thả hoặc sắp xếp lại từng khối.

Các khối có thể chỉnh:

1. Banner hero: eyebrow, title, highlight, description, ảnh desktop, ảnh mobile, nút chính, nút phụ.
2. Thống kê: danh sách số liệu, mỗi item có icon, số, hậu tố và nhãn.
3. Dịch vụ: heading, subtitle, link xem tất cả, danh sách card dịch vụ.
4. Dự án tiêu biểu: heading, link xem tất cả, danh sách project hiển thị.
5. Home Audit CTA: ảnh, nhãn, tiêu đề, mô tả, danh sách lợi ích, nút đăng ký.
6. Quy trình làm việc: heading, danh sách step, mỗi step có icon, số, title, description.
7. Testimonials: heading, link xem tất cả, danh sách đánh giá.
8. Partner logos: danh sách logo đối tác.

Ảnh trên homepage:

- Ảnh hero nên set cả desktop image và mobile image.
- Ảnh của dịch vụ, dự án, audit CTA, partner logo, testimonial avatar đều là field riêng trong từng block.

### 3.2. Trang Dịch vụ

Đây là archive của custom post type Dịch vụ.

Chỉnh phần nội dung archive tại LuxNova Settings > Nội dung trang lưu trữ dịch vụ.

Chỉnh card dịch vụ tại Services > từng service.

Các field có thể chỉnh trong archive settings:

1. Hero: eyebrow, title, description, ảnh desktop, ảnh mobile, nút chính, nút phụ.
2. Services heading: tiêu đề danh sách dịch vụ.
3. Card link label: nhãn link trên card.
4. Process heading: tiêu đề phần quy trình.
5. Why heading: tiêu đề phần lý do chọn.
6. Closing CTA: ảnh, title, description, button label.

Trong từng service, các mục cần chỉnh là:

1. Title của service.
2. Featured Image của bài service, dùng làm ảnh card.
3. Nội dung bài viết trong editor, dùng làm mô tả nếu không có excerpt.
4. Excerpt nếu muốn tự viết tóm tắt ngắn.
5. Field icon hoặc icon image để đổi icon hiển thị trên archive.

### 3.3. Trang Dự án

Đây là archive của custom post type Dự án.

Chỉnh phần hero và CTA cuối trang tại LuxNova Settings > Nội dung trang lưu trữ dự án.

Danh sách project trên archive lấy từ các bài Dự án đã xuất bản.

Nếu chưa có project thật, theme sẽ dùng card fallback mặc định.

Bạn cần chỉnh ở từng Project:

1. Title.
2. Featured Image.
3. Nội dung bài viết hoặc excerpt.
4. Field location.
5. Field area.
6. Field style.
7. Field completion year.

Nếu muốn lọc theo loại dự án, chỉnh taxonomy Loại dự án trong sidebar của post Dự án.

### 3.4. Trang Dự án tiêu biểu

Chỉnh tại Pages > Dự án tiêu biểu.

Nhóm ACF có tên Nội dung trang Dự án tiêu biểu.

Các phần chỉnh được:

1. Hero: eyebrow, title, highlight, description, ảnh, ảnh mobile.
2. Dự án hiển thị: chọn project muốn xuất hiện trên trang này.
3. Thông báo khi trống: text khi chưa chọn project nào.
4. Closing CTA: ảnh, title, description, button label.

Lưu ý:

- Nếu không chọn project nào, theme sẽ tự lấy các dự án mới nhất.
- Ảnh trước thi công và ảnh sau hoàn thiện nên chỉnh trong từng Project nếu muốn case study đẹp hơn.

### 3.5. Trang Chi tiết dự án

Chỉnh tại Projects > từng project.

Đây là trang quan trọng nhất nếu bạn muốn cập nhật nội dung case study, hình ảnh before/after và hồ sơ dự án.

Các mục cần nhập:

1. Featured Image: ảnh hero chính của trang dự án.
2. Nội dung bài viết: phần câu chuyện dự án.
3. Excerpt nếu muốn tóm tắt ngắn trên hero.
4. Field location: địa điểm.
5. Field area: diện tích.
6. Field style: phong cách.
7. Field completion year: năm hoàn thành.
8. Field scope: hạng mục thực hiện.
9. Field architect: đội ngũ phụ trách.
10. Field brochure: file PDF hoặc brochure tải về.
11. Field gallery: thư viện ảnh dự án.
12. Field gallery_videos: video dự án và ảnh poster nếu có.
13. Field hero_mobile_image: ảnh riêng cho mobile.

Các nhóm case study nâng cao trong post project:

1. Tổng quan case study.
2. Nhu cầu khách hàng.
3. Hiện trạng ban đầu.
4. Giải pháp LuxNova.
5. Kết quả đạt được.
6. Phản hồi khách hàng.
7. Tên khách hàng.
8. Ảnh khách hàng.
9. Ảnh trước thi công.
10. Ảnh sau hoàn thiện.

Nếu các trường nâng cao để trống, theme sẽ tự dùng dữ liệu mặc định hoặc lấy từ gallery/featured image.

### 3.6. Trang Liên hệ

Có 2 template fallback nhưng cùng một nội dung:

- page-lien-he.php
- page-contact.php

Chỉnh tại Pages > Liên hệ hoặc Pages > Contact, tùy page nào đang được gắn template.

Nhóm ACF là Nội dung trang liên hệ.

Các phần có thể chỉnh:

1. Hero: eyebrow, title, highlight, title suffix, description, ảnh desktop, ảnh mobile.
2. Hero trust items: danh sách cam kết hiển thị trên hero.
3. Form heading: tiêu đề form.
4. Info heading: tiêu đề khối thông tin liên hệ.
5. Contact items: địa chỉ, số điện thoại, email, giờ làm việc, fanpage hoặc mục custom khác.
6. Map block: iframe bản đồ, label, description, button label.
7. Closing CTA: ảnh, eyebrow, title, description, button label.

Lưu ý quan trọng:

- Nếu map block trên page trống, theme có thể dùng dữ liệu bản đồ trong LuxNova Settings.
- Contact items có icon chọn sẵn hoặc icon image riêng nếu cần.

### 3.7. Trang FAQ

Có 2 template fallback nhưng cùng một nội dung:

- page-faq.php
- page-cau-hoi-thuong-gap.php

Chỉnh tại Pages > FAQ hoặc Pages > Câu hỏi thường gặp.

Nhóm ACF là Nội dung trang FAQ.

Các phần chỉnh được:

1. Hero: eyebrow, title, highlight, description, ảnh desktop, ảnh mobile.
2. Sidebar: heading, description, button label, button icon, button icon image, button url.
3. FAQ items: danh sách câu hỏi và câu trả lời.
4. Closing CTA: ảnh, eyebrow, title, button label.

### 3.8. Trang Bảng giá

Chỉnh tại Pages > Bảng giá.

Nhóm ACF là Nội dung trang bảng giá.

Các phần chỉnh được:

1. Hero: eyebrow, title, description, ảnh desktop, ảnh mobile.
2. Plans heading: tiêu đề danh sách gói.
3. Pricing plans: danh sách gói giá, mỗi gói có label, title, price, unit, features, button label, ribbon, featured.
4. Plans note: ghi chú bảng giá.
5. Factors heading: tiêu đề yếu tố ảnh hưởng chi phí.
6. Cost factors: danh sách yếu tố, mỗi item có icon, icon image, title.
7. FAQ heading: tiêu đề phần FAQ báo giá.
8. Pricing FAQs: danh sách câu hỏi và trả lời.
9. FAQ image: ảnh minh họa bên phải.
10. Closing CTA: ảnh, title, description, button label.

### 3.9. Trang Kiến thức

Chỉnh tại Pages > Kiến thức, nếu site đang dùng page-kien-thuc.php.

Trang này không có ACF riêng. Nội dung lấy từ Posts > All Posts.

Khi muốn đăng bài cho trang Kiến thức, bạn cần chỉnh:

1. Title của bài viết.
2. Featured Image.
3. Nội dung bài viết.
4. Excerpt nếu muốn tự đặt đoạn mô tả.
5. Category để phân loại bài.

Trang Kiến thức hiển thị bài viết mới nhất, nên nếu muốn bài nào nổi bật hơn, hãy dùng ảnh đại diện mạnh và excerpt tốt.

## 4. Custom post type cần quản trị riêng

### 4.1. Projects

Vào Projects > Add New hoặc Projects > All Projects.

Nên nhập đủ:

1. Title.
2. Featured Image.
3. Nội dung chính.
4. Excerpt.
5. Field location.
6. Field area.
7. Field style.
8. Field budget.
9. Field timeline.
10. Field completion year.
11. Field scope.
12. Field architect.
13. Field brochure.
14. Field gallery.
15. Field gallery_videos.
16. Field hero_mobile_image.
17. Taxonomy Loại dự án.

### 4.2. Services

Vào Services > Add New hoặc Services > All Services.

Nên nhập:

1. Title.
2. Featured Image.
3. Nội dung bài viết.
4. Excerpt.
5. Field icon.
6. Field icon image nếu muốn dùng ảnh thay icon.

### 4.3. Đánh giá khách hàng

Vào Đánh giá khách hàng > Add New hoặc All items.

Nên nhập:

1. Title là tên khách hàng.
2. Nội dung bài viết nếu muốn làm nguồn dự phòng.
3. Field rating từ 1 đến 5.
4. Field quote.
5. Field project_context.
6. Field avatar hoặc Featured Image.

Đánh giá khách hàng được dùng trên homepage và các section testimonial của theme.

## 5. LuxNova Settings - cấu hình global

Vào LuxNova Settings trong sidebar admin.

Đây là nơi chỉnh các cấu hình dùng chung trên toàn site.

### 5.1. Brand

1. Brand logo image: logo ảnh dùng ở header và footer.
2. Brand logo text: tên logo chữ nếu chưa có ảnh.
3. Brand tagline: dòng mô tả thương hiệu.

### 5.2. Header

1. Header CTA: nút gọi hành động ở header.

### 5.3. Footer và liên hệ chung

1. Footer description: mô tả ngắn ở footer.
2. Phone: số điện thoại dùng toàn site.
3. Email: email liên hệ.
4. Address: địa chỉ.
5. Map iframe: iframe Google Maps dùng ở footer và fallback cho trang liên hệ.
6. Map image: ảnh bản đồ nếu không dùng iframe.
7. Social links: danh sách mạng xã hội.

### 5.4. SEO và chia sẻ

1. Default OG image: ảnh mặc định khi chia sẻ link website lên mạng xã hội.

### 5.5. Nội dung dùng chung cho archive và popup

1. Service archive content: hero, heading, CTA cho trang Dịch vụ.
2. Project archive content: hero và CTA cho trang Dự án.
3. Consultation modal content: nội dung popup tư vấn dùng ở nhiều nút CTA trên site.

## 6. Menu cần quản trị

Vào Appearance > Menus và gán đúng location.

1. Primary: menu chính trên header.
2. Footer Links: menu liên kết ở footer.
3. Footer Services: menu dịch vụ ở footer.
4. Footer Support: menu hỗ trợ ở footer.

Nếu chưa gán menu, theme vẫn có fallback mặc định, nhưng nên cấu hình menu thật để kiểm soát nội dung tốt hơn.

## 7. Cách chỉnh ảnh đúng chỗ

### 7.1. Ảnh hero

Nếu page có hero, thường sẽ có 2 ảnh:

1. Ảnh desktop.
2. Ảnh mobile.

Nên upload cả hai để tránh crop xấu trên điện thoại.

### 7.2. Ảnh card dự án và dịch vụ

1. Dự án dùng Featured Image của Project.
2. Dịch vụ dùng Featured Image của Service.
3. Featured projects trên homepage và trang Dự án tiêu biểu lấy ảnh từ project đã chọn.

### 7.3. Ảnh gallery

1. Project gallery dùng field gallery.
2. Video project dùng gallery_videos và poster nếu có.
3. Ảnh case study before/after dùng case_before_images và case_after_images.

### 7.4. Ảnh logo và social

1. Logo site chỉnh trong LuxNova Settings.
2. Social icons có thể dùng icon chọn sẵn hoặc icon image riêng.

### 7.5. Ảnh bản đồ

1. Map iframe dùng cho bản đồ live.
2. Map image dùng làm phương án thay thế nếu không có iframe.

## 8. Quy tắc làm việc an toàn khi edit nội dung

1. Không xóa các field mặc định nếu chưa chắc chúng đang được dùng ở đâu.
2. Khi sửa ảnh, nên kiểm tra cả desktop và mobile.
3. Nếu một khu vực trên site chưa đổi như mong muốn, kiểm tra xem nó đang lấy dữ liệu từ page template, CPT hay LuxNova Settings.
4. Với các trang fallback như Contact và FAQ, nội dung thực tế có thể đến từ cùng một template nên sửa một nơi là đủ.

## 9. Bảng tra cứu nhanh

| Khu vực trên site | Chỉnh ở đâu |
| --- | --- |
| Trang chủ | Pages > Trang chủ > Các khối trang chủ |
| Trang Dịch vụ | LuxNova Settings > Nội dung trang lưu trữ dịch vụ, và Services |
| Trang Dự án | LuxNova Settings > Nội dung trang lưu trữ dự án, và Projects |
| Trang Dự án tiêu biểu | Pages > Dự án tiêu biểu |
| Trang chi tiết dự án | Projects > từng project |
| Trang Liên hệ | Pages > Liên hệ hoặc Contact |
| Trang FAQ | Pages > FAQ hoặc Câu hỏi thường gặp |
| Trang Bảng giá | Pages > Bảng giá |
| Trang Kiến thức | Posts > All Posts |
| Header | LuxNova Settings > Header CTA, Appearance > Menus |
| Footer | LuxNova Settings > Footer description, contact, social, và Appearance > Menus |
| Popup tư vấn | LuxNova Settings > Consultation modal content |

## 10. Ghi chú cho editor

Nếu bạn chỉ cần sửa chữ, hãy tìm đúng page hoặc setting tương ứng trước. Nếu bạn cần đổi cả ảnh và nội dung, hãy ưu tiên sửa trong cùng một nơi để tránh lệch giữa các trang.

Nếu muốn, có thể mở rộng tài liệu này thành checklist thao tác cho từng loại editor: content writer, designer và sales/admin.