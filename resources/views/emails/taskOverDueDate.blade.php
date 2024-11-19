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
                    <td class="container" width="600"
                        style="display: block; max-width: 600px; margin: 0 auto; background-color: #fff;">
                        <div class="content" style="padding: 20px;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0"
                                style="border-radius: 7px; background-color: #fff; box-shadow: 0 3px 15px rgba(30,32,37,.06);">
                                <tr>
                                    <td class="content-wrap" style="padding: 30px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="content-block" style="text-align: center; margin-bottom: 15px;">
                                                    <h1 style="font-size: 24px; color: #e7515a;">Task Flow</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="text-align: center; font-size: 20px; font-weight: 500;">
                                                    Task đã quá hạn!
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="color: #878a99; text-align: left; font-size: 15px; padding-top: 15px;">
                                                    <p><strong>Task:</strong> {{ $task->text }}</p>
                                                    <p><strong>Thời hạn:</strong> {{ $task->end_date->format('d/m/Y H:i') }}</p>
                                                    <p><strong>Danh mục:</strong> {{ $task->catalog->name }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block"
                                                    style="text-align: left; font-size: 14px; line-height: 1.5; color: #495057; padding-top: 15px;">
                                                    <p>Chào bạn,</p>
                                                    <p>Task "<strong>{{ $task->text }}</strong>" đã quá hạn. Vui lòng kiểm tra lại và cập nhật để đảm bảo tiến độ.</p>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="content-block" style="text-align: center; padding-top: 20px;">
                                                    <a href="{{ url('/b/' . $task->catalog->board->id . '/edit') }}"
                                                        style="padding: 10px 20px; background-color: #e7515a; color: #fff; text-decoration: none; border-radius: 5px;">
                                                        Xem Task
                                                    </a>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td class="content-block"
                                                    style="color: #878a99; text-align: center; font-size: 14px; padding-top: 20px; border-top: 1px solid #e9ebec;">
                                                    Nếu bạn nhận được email này do nhầm lẫn, vui lòng xóa nó.
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="text-align: center; margin-top: 25px;">
                                            <ul style="list-style: none; display: flex; justify-content: center; gap: 15px; padding-left: 0;">
                                                <li><a href="#" style="color: #495057;">Trung tâm hỗ trợ</a></li>
                                                <li><a href="#" style="color: #495057;">Hỗ trợ 24/7</a></li>
                                                <li><a href="#" style="color: #495057;">Tài khoản</a></li>
                                            </ul>
                                            <p style="font-size: 14px; color: #98a6ad;">2024 Task Flow. Thiết kế & phát triển bởi đội ngũ TaskFlow.</p>
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
