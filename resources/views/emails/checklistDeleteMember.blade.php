<!-- resources/views/emails/taskAssigned.blade.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao Check List Mới</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f7fa;
            color: #34495e;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #2980b9;
            /* Màu xanh dương đậm */
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 16px;
        }

        .content {
            padding: 30px;
            font-size: 16px;
            line-height: 1.6;
            color: #495057;
            border-top: 5px solid #2980b9;
            /* Màu xanh dương */
        }

        .task-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #2980b9;
            /* Màu xanh dương */
        }

        .task-details h2 {
            margin-top: 0;
            color: #2980b9;
            /* Màu xanh dương */
        }

        .cta-button {
            display: inline-block;
            margin-top: 15px;
            background-color: #27ae60;
            /* Màu xanh lá cây */
            color: #ffffff;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
        }

        .cta-button:hover {
            background-color: #219653;
            /* Màu xanh lá cây đậm hơn */
        }

        .footer {
            background-color: #ecf0f1;
            /* Màu xám sáng */
            color: #7f8c8d;
            /* Màu xám */
            text-align: center;
            padding: 20px;
            font-size: 14px;
            border-top: 1px solid #dcdcdc;
        }

        .footer a {
            color: #2980b9;
            /* Màu xanh dương */
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Xóa khỏi Checklist</h1>
            <p>{{ $adminName }} đã xóa bạn khỏi checklist cho nhiệm vụ
                "{{ $checkListItemMember->checkListItem->checkList->task->text }}"!</p>
        </div>
        <div class="content">
            <p>Chi tiết Checklist:</p>
            <p><strong>Tên Checklist:</strong> {{ $checkListItemMember->checkListItem->checkList->name }}</p>
            <p><strong>Nhiệm vụ:</strong> {{ $checkListItemMember->checkListItem->checkList->task->text }}</p>
            <p><strong>Thao tác bởi:</strong> {{ $adminName }}</p>
            <p>Bạn đã được xóa khỏi checklist này. Nếu có thắc mắc, vui lòng liên hệ với quản trị viên.</p>
        </div>
        <div class="footer">
            Đây là email tự động, vui lòng không trả lời email này.
        </div>
    </div>
</body>

</html>
