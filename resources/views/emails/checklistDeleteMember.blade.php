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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h5 {
            color: #333;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content-block {
            color: #495057;
            margin-bottom: 20px;
        }

        .content-block p {
            color: #878a99;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #0ab39c;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 500;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.2s;
        }

        a:hover {
            background-color: #099885;
            transform: scale(1.05);
        }

        footer {
            text-align: center;
            margin-top: 25px;
        }

        footer ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        footer a {
            color: #495057;
            font-weight: 600;
        }

        footer p {
            color: #98a6ad;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-12">
            <table class="body-wrap"
                style="font-family: 'Roboto', sans-serif; width: 100%; background-color: #f8f9fa; margin-top: -50px;">
                <tr>
                    <td></td>
                    <td class="container" width="600" style="display: block; max-width: 600px; margin: 0 auto;">
                        <div class="content" style="padding: 20px;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0"
                                style="border-radius: 7px; background-color: #fff; box-shadow: 0 3px 15px rgba(30, 32, 37, .06);">
                                <tr>
                                    <td class="content-wrap" style="padding: 30px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="content-block"
                                                    style="text-align: center; margin-bottom: 15px;">
                                                    <h1 style="font-size: 24px; color: #0ab39c;">Task Flow</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="text-align: center; font-size: 20px; font-weight: 500;">
                                                    {{ $adminName }} đã xóa bạn khỏi checklist cho nhiệm vụ
                                                    "{{ $checkListItemMember->checkListItem->checkList->task->text }}"!
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="color: #878a99; text-align: left; font-size: 15px; padding-top: 15px;">
                                                    <p><strong>Tên Checklist:</strong>
                                                        {{ $checkListItemMember->checkListItem->checkList->name }}</p>
                                                    <p><strong>Nhiệm vụ:</strong>
                                                        {{ $checkListItemMember->checkListItem->checkList->task->text }}
                                                    </p>
                                                    <p><strong>Thao tác bởi:</strong> {{ $adminName }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="text-align: left; font-size: 14px; line-height: 1.5; color: #495057; padding-top: 15px;">
                                                    <p>Chào bạn,</p>
                                                    <p>{{ $adminName }} đã xóa bạn khỏi checklist cho nhiệm vụ
                                                        "<strong>{{ $checkListItemMember->checkListItem->checkList->task->text }}</strong>".
                                                        Nếu có thắc mắc, vui lòng liên hệ với quản trị
                                                        viên.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="color: #878a99; text-align: center; font-size: 14px; padding-top: 20px; border-top: 1px solid #e9ebec;">
                                                    Nếu bạn nhận được email này do nhầm lẫn, vui lòng xóa nó.
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="text-align: center; margin-top: 25px;">
                                            <ul
                                                style="list-style: none; display: flex; justify-content: center; gap: 15px; padding-left: 0;">
                                                <li><a href="#" style="color: #495057;">Trung tâm hỗ trợ</a></li>
                                                <li><a href="#" style="color: #495057;">Hỗ trợ 24/7</a></li>
                                                <li><a href="#" style="color: #495057;">Tài khoản</a></li>
                                            </ul>
                                            <p style="font-size: 14px; color: #98a6ad;">2024 Task Flow. Thiết kế & phát
                                                triển bởi đội ngũ TaskFlow.</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>


</html>


</html>
