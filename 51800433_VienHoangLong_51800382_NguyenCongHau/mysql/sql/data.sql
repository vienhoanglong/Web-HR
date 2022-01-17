-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: mysql-server
-- Thời gian đã tạo: Th1 15, 2022 lúc 01:45 PM
-- Phiên bản máy phục vụ: 8.0.1-dmr
-- Phiên bản PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `company_management`
--
CREATE DATABASE IF NOT EXISTS `company_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `company_management`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accept_calendar`
--

CREATE TABLE `accept_calendar` (
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ngayDaNghi` int(2) NOT NULL DEFAULT '0',
  `ngayConLai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `accept_calendar`
--

INSERT INTO `accept_calendar` (`username`, `ngayDaNghi`, `ngayConLai`) VALUES
('lehienluong', 0, 12),
('nguyenconghau', 4, 8),
('nguyenhaivan', 0, 15),
('nguyenhoaithuong', 0, 15),
('nguyenngochuyen', 2, 13),
('nguyenvanmanh', 2, 10),
('phamhonghaidang', 0, 12),
('tranthikimtuyen', 7, 8),
('vienhoanglong', 11, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ngayBatDau` date NOT NULL,
  `ngayKetThuc` date NOT NULL,
  `trangThai` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'Chờ duyệt',
  `liDo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thoiGianTao` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `calendar`
--

INSERT INTO `calendar` (`id`, `username`, `position`, `department`, `ngayBatDau`, `ngayKetThuc`, `trangThai`, `liDo`, `file`, `thoiGianTao`) VALUES
(2, 'vienhoanglong', 'Manager', 'Phòng Công nghệ thông tin', '2022-01-04', '2022-01-06', 'Đã duyệt', 'Về quê ăn tết 1/1/2020', NULL, '2022-01-05 03:56:07'),
(3, 'tranthikimtuyen', 'Manager', 'Phòng thiết kế', '2022-01-05', '2022-01-07', 'Đã duyệt', 'Việc cá nhân ', NULL, '2022-01-05 03:56:07'),
(4, 'vienhoanglong', 'Manager', 'Phòng Công nghệ thông tin', '2022-01-06', '2022-01-08', 'Đã duyệt', 'Về quê', NULL, '2022-01-05 17:50:42'),
(5, 'vienhoanglong', 'Manager', 'Phòng Công nghệ thông tin', '2022-01-07', '2022-01-09', 'Đã duyệt', 'Nghỉ phép', NULL, '2022-01-05 18:56:13'),
(6, 'vienhoanglong', 'Manager', 'Phòng Công nghệ thông tin', '2022-01-07', '2022-01-09', 'Đã duyệt', 'Về quê', NULL, '2022-01-05 18:57:35'),
(7, 'tranthikimtuyen', 'Manager', 'Phòng thiết kế', '2022-01-06', '2022-01-10', 'Đã duyệt', 'Về quê', NULL, '2022-01-05 19:00:02'),
(8, 'vienhoanglong', 'Manager', 'Phòng Công nghệ thông tin', '2022-01-06', '2022-01-07', 'Đã duyệt', 'Ve que', NULL, '2022-01-06 01:59:18'),
(9, 'tranthikimtuyen', 'Manager', 'Phòng thiết kế', '2022-01-07', '2022-01-09', 'Đã duyệt', 'Ve que', NULL, '2022-01-07 14:28:37'),
(10, 'tranthikimtuyen', 'Manager', 'Phòng thiết kế', '2022-01-10', '2022-01-11', 'Không duyệt', 'Về quê', NULL, '2022-01-10 13:23:27'),
(11, 'nguyenngochuyen', 'Manager', 'Phòng Nhân Sự', '2022-01-11', '2022-01-13', 'Đã duyệt', 'Về quê', NULL, '2022-01-10 20:26:02'),
(12, 'nguyenconghau', 'Employee', 'Phòng Marketing', '2022-01-11', '2022-01-13', 'Không duyệt', 'Về quê', NULL, '2022-01-11 01:01:03'),
(13, 'nguyenconghau', 'Employee', 'Phòng Marketing', '2022-01-11', '2022-01-13', 'Đã duyệt', 'Về quê', NULL, '2022-01-11 13:49:18'),
(14, 'nguyenconghau', 'Employee', 'Phòng Marketing', '2022-01-14', '2022-01-16', 'Đã duyệt', 'Về quê', NULL, '2022-01-11 14:28:46'),
(15, 'nguyenvanmanh', 'Employee', 'Phòng Công nghệ thông tin', '2022-01-15', '2022-01-17', 'Đã duyệt', 'Về quê', NULL, '2022-01-15 13:06:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department`
--

CREATE TABLE `department` (
  `idDepartment` int(11) NOT NULL,
  `nameDepartment` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `addressDepartment` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `manager` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descDepartment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `department`
--

INSERT INTO `department` (`idDepartment`, `nameDepartment`, `addressDepartment`, `manager`, `descDepartment`, `status`) VALUES
(2, 'Phòng thiết kế', 'Tầng 3B', 'tranthikimtuyen', 'Phòng thiết kế có nhiệm vụ thiết kế sản phẩm phục vụ cho công ty', b'1'),
(3, 'Phòng Marketing', 'Tầng 3C', 'nguyenhoaithuong', 'Xây dựng và phát triển thương hiệu là hoạt động quan trọng của doanh nghiệp vì nó giúp doanh nghiệp đạt được thành công và tạo được vị thế cạnh tranh trên thị trường. Ngay từ đầu doanh nghiệp cần chú ý xây dựng hình ảnh thương hiệu nhất quán và xuyên suốt, tất cả các hình ảnh và thông điệp cần được truyền tải một cách rõ ràng, chính xác, và hấp dẫn nhằm thu hút sự quan tâm của khách hàng mục tiêu. Điều này sẽ giúp doanh nghiệp tạo dựng niềm tin với khách hàng và nâng cao giá trị thương hiệu. ', b'1'),
(4, 'Phòng Nhân Sự', 'Tầng 1A', 'nguyenngochuyen', ' Bộ phận này cũng chịu trách nhiệm tuyển dụng, tuyển dụng, sa thải và quản lý các quyền lợi. Các công ty thường chú trọng rất nhiều tới bộ phận quan trọng này và nên thường xuyên cho nhân viên tham gia các khóa học quản trị nhân sự để nâng cao nhân lực và tăng hiệu quả công việc.', b'1'),
(5, 'Phòng Tài Chính', 'Tầng 2A', 'nguyenhaivan', 'Phòng tài chính có vai trò quan trọng trong việc đảm bảo doanh nghiệp có đủ lượng tiền mặt cần thiết phục vụ cho các hoạt động kinh doanh và đảm bảo doanh nghiệp đang quản lý và sử dụng nguồn tiền hiệu quả nhất cũng như đủ để đáp ứng toàn bộ các nghĩa vụ tài chính của doanh nghiệp.', b'1'),
(12, 'Phòng Kỹ Thuật', 'Tầng 2B', '', 'Xây dựng và phát triển thương hiệu là hoạt động quan trọng của doanh nghiệp vì nó giúp doanh nghiệp đạt được thành công và tạo được vị thế cạnh tranh trên thị trường. Ngay từ đầu doanh nghiệp cần chú ý xây dựng hình ảnh thương hiệu nhất quán và xuyên suốt, tất cả các hình ảnh và thông điệp cần được truyền tải một cách rõ ràng, chính xác, và hấp dẫn nhằm thu hút sự quan tâm của khách hàng mục tiêu. Điều này sẽ giúp doanh nghiệp tạo dựng niềm tin với khách hàng và nâng cao giá trị thương hiệu. ', b'0'),
(13, 'Phòng Công nghệ thông tin', 'Tầng 3A', 'vienhoanglong', 'Phòng công nghệ thông tin có chức năng quản lý các phần mềm, hỗ trợ lắp đặt,... liên quan tới công nghệ và kỹ thuật trong công ty', b'1'),
(14, 'Phòng Media', 'Tầng 6B', NULL, 'Phòng Media Test Update', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `list_task`
--

CREATE TABLE `list_task` (
  `id` int(11) NOT NULL,
  `name_manager` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_employee` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_task` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc_task` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deadline` datetime NOT NULL,
  `time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `list_task`
--

INSERT INTO `list_task` (`id`, `name_manager`, `name_employee`, `department`, `name_task`, `desc_task`, `status`, `file`, `deadline`, `time_created`, `rating`) VALUES
(14, 'vienhoanglong', 'lehienluong', 'Phòng Công nghệ thông tin', 'Thiết kế website bán hàng', 'Thiết kế website bán hàng có các trang như\r\n- Trang chủ\r\n- Trang sản phẩm\r\n- Footer\r\n- NavBar\r\n....', 'Completed', 'Frontend.txt', '2022-01-15 23:49:00', '2022-01-14 03:23:39', 'Ok'),
(15, 'vienhoanglong', 'lehienluong', 'Phòng Công nghệ thông tin', 'Lập trình ứng đụng di động', 'Lập trình ứng dụng di dộng', 'In Progress', 'Account.png', '2022-01-27 23:59:00', '2022-01-14 10:33:45', ''),
(16, 'vienhoanglong', 'lehienluong', 'Phòng Công nghệ thông tin', 'Viết website food', 'Viết website food', 'Canceled', 'Screenshot 2021-12-19 170728.png', '2022-01-14 22:16:00', '2022-01-14 15:16:47', ''),
(17, 'vienhoanglong', 'lehienluong', 'Phòng Công nghệ thông tin', 'Long1', 'Long Long Long Long1', 'Completed', 'Product details.png', '2022-01-16 01:44:00', '2022-01-14 15:35:44', 'Ok'),
(18, 'vienhoanglong', 'lehienluong', 'Phòng Công nghệ thông tin', 'Tạo Front end website', 'Tesk', 'Waiting', 'Account.png', '2022-01-14 07:27:00', '2022-01-15 00:27:27', NULL),
(19, 'vienhoanglong', 'lehienluong', 'Phòng Công nghệ thông tin', 'ádadasd', 'áddasd', 'Rejected', 'Account.png', '2022-01-15 09:20:00', '2022-01-15 02:20:24', NULL),
(20, 'vienhoanglong', 'nguyenvanmanh', 'Phòng Công nghệ thông tin', 'Tạo website nghe nhạc', 'Website sẽ có các tính năng như xem nhạc, phát nhạc, giao diện người dùng như các danh mục bài hát yêu thích, đề xuất danh sách nghe theo sở thích', 'Waiting', 'Home.png', '2022-01-18 23:59:00', '2022-01-15 13:14:34', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_process`
--

CREATE TABLE `task_process` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file_submit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submit_status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_submit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_process`
--

INSERT INTO `task_process` (`id`, `task_id`, `comment`, `user`, `file_submit`, `submit_status`, `time_submit`) VALUES
(4, 14, 'Update', 'lehienluong', 'Account.png', 'Turn in', '2022-01-14 04:23:47'),
(5, 14, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'lehienluong', 'Swimlane-Swimlane-QTBaoTriTS.drawio (1).png', 'Turn in', '2022-01-14 04:51:49'),
(9, 14, 'Giao diện không ổn thực hiện lại', 'vienhoanglong', '', 'Manager reject', '2022-01-14 09:42:11'),
(10, 14, 'Hoàn thành ', 'lehienluong', 'Account.png', 'Turn in', '2022-01-14 09:48:32'),
(11, 14, 'Giao diện vẫn chưa được, cần chú trọng vào thiết kế và bố cục website', 'vienhoanglong', 'Product details.png', 'Manager reject', '2022-01-14 09:50:59'),
(12, 14, 'Hoan thanh yeu cau', 'lehienluong', 'Account.png', 'Turn in', '2022-01-14 15:13:23'),
(13, 17, 'Hoan thanh', 'lehienluong', 'Account.png', 'Turn in', '2022-01-15 00:07:20'),
(14, 17, 'Chua hop le', 'vienhoanglong', '', 'Manager reject', '2022-01-15 00:07:43'),
(15, 18, 'submit', 'lehienluong', 'Account.png', 'Turn in late', '2022-01-15 00:27:51'),
(16, 19, 'Hello', 'lehienluong', 'Account.png', 'Turn in', '2022-01-15 02:32:23'),
(17, 19, 'Chưa đươcjk', 'vienhoanglong', 'Account.png', 'Manager reject', '2022-01-15 02:32:48'),
(18, 19, 'hello', 'lehienluong', 'Account.png', 'Turn in', '2022-01-15 02:34:11'),
(19, 19, 'jkhjkh', 'vienhoanglong', '', 'Manager reject', '2022-01-15 02:37:42'),
(20, 20, 'Hoàn thành task ', 'nguyenvanmanh', 'Home.png', 'Turn in', '2022-01-15 13:17:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` bit(1) DEFAULT b'0',
  `activate_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `avatar`, `password`, `activated`, `activate_token`, `department`, `position`, `role`) VALUES
(1, 'admin123', 'Admin', 'admin123@gmail.com', 'ava3.png', '$2y$10$s4T5EVcP6CTTpcDTUU.SIuVJy0x14MjUqWtoFfwvc/BmGY/71.lPC', b'1', '1d13db03348cf5b6d7333564f88abf21', NULL, NULL, 0),
(51, 'tranthikimtuyen', 'Trần Thị Kim Tuyến', 'tranthikimtuyen@gmail.com', 'avatar.png', '$2y$10$wkMuKW1qyohTsqJxZ1QWNOAlC1AtS/L3hlJVshrlmlOEATcsCNOqq', b'1', '66d0a719955ae4e4b737418e01cbf299', 'Phòng thiết kế', 'Manager', 1),
(52, 'lehienluong', 'Lê Hiền Lương', 'lehienluong@gmail.com', 'avatar.png', '$2y$10$cmffQkq4p06S8ynLHgFSue9VmuSwyUcfUR5KRzQLtw1NA5K3QDDAy', b'1', '99963560945cca0f556be6a3ff93ed21', 'Phòng Công nghệ thông tin', 'Employee', 2),
(53, 'tranhoanglong', 'Trần Hoàng Long', 'tranhoanglong@gmail.com', 'avatar.png', '$2y$10$IKoeWxTDpIHkseYTNtToZ.WH/J2y3izlRSYaUgoUORowE.kwAJTRm', b'0', '5a46f1f5c1c7b2908651dc02d5c4768f', 'Phòng Công nghệ thông tin', 'Employee', 2),
(55, 'vienhoanglong', 'Viên Hoàng Long', 'Vienhoanglong789@gmail.com', 'manager.png', '$2y$10$5rQU6rLyhytHbwul2u.ABu08uxmSgLavG7KI4kfJ0aBp2LL4hrsNO', b'1', 'c440be6c3d9a2a2e23faae58c4d4f50c', 'Phòng Công nghệ thông tin', 'Manager', 1),
(56, 'hoanglong', 'Hoàng Long', 'hoanglong@gmail.com', 'avatar.png', '$2y$10$zSIozvdAF4CIPi98CxAixOXusMZ8DrWaWVFE4PcffYgSl8WVPHGWa', b'1', 'f89e94212a11c84c109c9ceccd69ceb6', 'Phòng Công nghệ thông tin', 'Employee', 2),
(57, 'nguyenconghau', 'Nguyễn Công Hậu', 'nguyenconghau@gmail.com', 'avatar.png', '$2y$10$.1KwZrtDgHyTdcGNzjSYpOlbRCU05Bq26foBbzXKNHy8NX0otH9Mi', b'1', '7192b3e3f325b866627c11b7c91d186d', 'Phòng Marketing', 'Employee', 2),
(58, 'nguyenhoaithuong', 'Nguyễn Hoài Thương', 'nguyenhoaithuong@gmail.com', 'ava1.png', '$2y$10$dg3Uv66s12f47e3zWyf3jO5qhMO6PqF99k/8TTvb/ivyEFJjU5ma6', b'1', '55d8c5be52c22085b39d1381d96c620a', 'Phòng Marketing', 'Manager', 1),
(61, 'huynhthanhtrung', 'Huỳnh Thành Trung', 'huynhthanhtrung@gmail.com', 'avatar.png', '$2y$10$ahVoIsgNIYznLzO3K7kwe.eZ1TcsH82PS4ZY8/714JlCXNqKpRDti', b'0', '0ab9072ab21b7aaae651b2a7cba559c2', 'Phòng thiết kế', 'Employee', 2),
(62, 'nguyenngochuyen', 'Nguyễn Ngọc Huyền', 'nguyenngochuyen@gmail.com', 'avatar.png', '$2y$10$mdGF5Xwdetq.SWomBzAWKegV6k.HBtcWD0Nfx94bjx2IF9IowvLLq', b'1', 'c9eab419a143eb045abeb71bb9bfa033', 'Phòng Nhân Sự', 'Manager', 1),
(63, 'diepphuc', 'Diệp Phúc', 'diepphuc@gmail.com', 'avatar.png', '$2y$10$7iDLuD9JMETWus3UU6Ju2.et9KsxOPva6HkAt7S0j1MFQ.m9kY1gy', b'0', 'c64b3a6081086310198199c1be11e28f', 'Phòng Kỹ Thuật', 'Employee', 2),
(64, 'phamhonghaidang', 'Phạm Hồng Hải Đăng', 'phamhonghaidang@gmail.com', 'avatar.png', '$2y$10$zk7/RAp1MmIez3b1MczCyOgM7tRNKhn/6o/OLMOF9AtPUzmIHnp3G', b'0', '12fcb6874a0a6ca20dac509b7e71c5ff', 'Phòng Công nghệ thông tin', 'Employee', 2),
(65, 'nguyenhaivan', 'Nguyễn Hải Vân', 'nguyenhaivan@gmail.com', 'avatar.png', '$2y$10$0h5ygSkcgMceGk1lnNmcMOm.B90.xTEiyGC1yxrvUd5Da4l8m0m4q', b'0', '88d7e4cec8f39212965f2463e28167e6', 'Phòng Tài Chính', 'Manager', 1),
(66, 'nguyenvanmanh', 'Nguyễn Văn Mạnh', 'nguyenvanmanh@gmail.com', 'admin.png', '$2y$10$Su.0gseohVsNTuqIdRM7Uuqb9TSSjlNdGZRDHjq0C9mUe8mjraWtq', b'1', '51076cef46ae3f710991098bf6e70712', 'Phòng Công nghệ thông tin', 'Employee', 2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accept_calendar`
--
ALTER TABLE `accept_calendar`
  ADD PRIMARY KEY (`username`);

--
-- Chỉ mục cho bảng `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`idDepartment`);

--
-- Chỉ mục cho bảng `list_task`
--
ALTER TABLE `list_task`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `task_process`
--
ALTER TABLE `task_process`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `department`
--
ALTER TABLE `department`
  MODIFY `idDepartment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `list_task`
--
ALTER TABLE `list_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `task_process`
--
ALTER TABLE `task_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
